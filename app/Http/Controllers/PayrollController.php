<?php

namespace App\Http\Controllers;

use App\Models\BasicPay;
use App\Models\Payroll;
use App\Models\Payoff;
use App\Models\Advance;
use App\Models\Department;
use App\Models\Timesheet;
use App\Models\BusinessResult;
use App\Models\InsurancePay;
use App\Models\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $year_month = $request->thang_nam;
        $department = $request->phong_ban;
        $payrolls = new Payroll;
        if ($year_month != null) {
            $payrolls = $payrolls->whereYearMonth($year_month);
        }
        if ($department != null && $department != 'Tất cả phòng ban') {
            $department = Department::whereName($department)->first();
            $payrolls = $payrolls->whereDepartmentId($department->id);
        }
        $payrolls = $payrolls->get();
        return view('pages.payrolls.index')->with(compact('payrolls'));
    }

    public function create(Request $request)
    {
        if (Session::has('timesheet_ids')) {
            $timesheet_ids = Session::get('timesheet_ids');
            $timesheets = Timesheet::whereIn('id', $timesheet_ids)->get();
            foreach ($timesheets as $timesheet) {
                $timesheet->basic_pay_amount = BasicPay::whereIsActive(1)->whereEmployeeId($timesheet->employee_id)->sum('basic_pay_amount');
                $timesheet->business_days_amount = $timesheet->basic_pay_amount / $timesheet->business_days_in_month * $timesheet->business_days;
                $timesheet->leave_days_amount = $timesheet->business_days_amount / $timesheet->business_days * $timesheet->leave_days * (-1);
                $timesheet->unauthorized_leave_days_amount = $timesheet->business_days_amount / $timesheet->business_days * $timesheet->unauthorized_leave_days * 2 * (-1);
                $timesheet->kpi = $this->get_kpi($timesheet);
                $timesheet->kpi_bonus_amount = $this->get_kpi_bonus_amount($timesheet);
                $timesheet->working_days_amount = $timesheet->business_days_amount + $timesheet->leave_days_amount + $timesheet->unauthorized_leave_days_amount + $timesheet->kpi_bonus_amount;
                $timesheet->seniority_years = $timesheet->employee->seniority_years;
                $timesheet->seniority_allowance_amount = $timesheet->seniority_years > 2 ? ($timesheet->seniority_years - 1) * $timesheet->business_days_amount * 0.1 : 0;
                $timesheet->position_allowance_amount = $timesheet->position->position_allowance_amount;
                $timesheet->parking_allowance_amount = $timesheet->assignment->is_parking_allowance ? Setting::first()->parking_allowance_amount : 0;
                $timesheet->sleep_at_shop_allowance_amount = $timesheet->assignment->is_sleep_at_shop_allowance ? Setting::first()->sleep_at_shop_allowance_amount : 0;
                $timesheet->sum_of_allowances_amount = $timesheet->seniority_allowance_amount + $timesheet->position_allowance_amount + $timesheet->parking_allowance_amount + $timesheet->sleep_at_shop_allowance_amount;
                $timesheet->sum_of_working_days_and_allowances_amount = $timesheet->working_days_amount + $timesheet->sum_of_allowances_amount;
                $timesheet->social_insurance_pay_amount = $timesheet->sum_of_working_days_and_allowances_amount * 0.085 * (-1);
                $timesheet->health_insurance_pay_amount = $timesheet->sum_of_working_days_and_allowances_amount * 0.015 * (-1);
                $timesheet->unemployment_insurance_pay_amount = $timesheet->sum_of_working_days_and_allowances_amount * 0.01 * (-1);
                $timesheet->sum_of_insurances_amount = $timesheet->social_insurance_pay_amount + $timesheet->health_insurance_pay_amount + $timesheet->unemployment_insurance_pay_amount;
                $timesheet->payoff_amount = Payoff::whereYearMonth($timesheet->year_month)->whereEmployeeId($timesheet->employee->id)->sum('payoff_amount');
                $timesheet->sum_of_payrolls_amount = $timesheet->sum_of_working_days_and_allowances_amount + $timesheet->sum_of_insurances_amount + $timesheet->payoff_amount;
                $timesheet->advance_amount = Advance::whereYearMonth($timesheet->year_month)->whereEmployeeId($timesheet->employee->id)->sum('advance_amount');
                $timesheet->take_home_pay_amount = $timesheet->sum_of_payrolls_amount + $timesheet->advance_amount;
            }
            Session::put('timesheets', $timesheets);
            return view('pages.payrolls.create')->with(compact('timesheets'));
        }
        Session::flash('failed', 'Không tìm thấy danh sách nhân viên cần tính lương');
        return redirect()->route('payrolls.calculate');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->ma_bang_cong); $i++) {
                Payroll::create([
                    'year_month'                        => $request->thang_nam[$i],
                    'basic_pay_amount'                  => $request->luong_co_ban[$i],
                    'business_days_amount'              => $request->luong_ngay_cong_chuan[$i],
                    'leave_days_amount'                 => $request->tru_luong_nghi_co_phep[$i],
                    'unauthorized_leave_days_amount'    => $request->tru_luong_nghi_khong_phep[$i],
                    'working_days_amount'               => $request->luong_ngay_cong[$i],
                    'kpi'                               => $request->kpi[$i],
                    'kpi_bonus_amount'                  => $request->thuong_kpi[$i],
                    'seniority_allowance_amount'        => $request->phu_cap_tham_nien[$i],
                    'position_allowance_amount'         => $request->phu_cap_chuc_vu[$i],
                    'parking_allowance_amount'          => $request->phu_cap_gui_xe[$i],
                    'sleep_at_shop_allowance_amount'    => $request->phu_cap_truc_sieu_thi[$i],
                    'sum_of_allowances_amount'          => $request->tong_phu_cap[$i],
                    'social_insurance_pay_amount'       => $request->dong_bhxh[$i],
                    'health_insurance_pay_amount'       => $request->dong_bhyt[$i],
                    'unemployment_insurance_pay_amount' => $request->dong_bhtn[$i],
                    'sum_of_insurances_amount'          => $request->tong_dong_bao_hiem[$i],
                    'payoff_amount'                     => $request->tong_thuong_phat[$i],
                    'sum_of_payrolls_amount'            => $request->tong_luong[$i],
                    'advance_amount'                    => $request->tong_tam_ung[$i],
                    'take_home_pay_amount'              => $request->thuc_lanh[$i],
                    'note'                              => $request->ghi_chu[$i],
                    'employee_id'                       => $request->ma_nhan_vien[$i],
                    'department_id'                     => $request->ma_phong_ban[$i],
                    'position_id'                       => $request->ma_chuc_vu[$i],
                    'timesheet_id'                      => $request->ma_bang_cong[$i],
                ]);

                InsurancePay::create([
                    'year_month'                        => $request->thang_nam[$i],
                    'health_insurance_pay_amount'       => $request->dong_bhyt[$i],
                    'social_insurance_pay_amount'       => $request->dong_bhxh[$i],
                    'unemployment_insurance_pay_amount' => $request->dong_bhtn[$i],
                    'employee_id'                       => $request->ma_nhan_vien[$i],
                ]);
            }
            DB::commit();
            return redirect()->route('payrolls.index')->with('success', 'Lập bảng lương thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('success', 'Lập bảng lương thất bại')->withError($e->getMessage())->withInput();
        }
    }

    public function show(Payroll $payroll)
    {
        //
    }

    public function edit(Payroll $payroll)
    {
        //
    }

    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    public function destroy(Payroll $payroll)
    {
        //
    }

    public function send_calculate_request(Request $request)
    {
        Session::put('timesheet_ids', $request->ma_bang_cong);
        return redirect()->route('payrolls.create');
    }

    public function calculate(Request $request)
    {
        $year_month = $request->thang_nam;
        $department = $request->phong_ban;
        $payrolls = Payroll::pluck('timesheet_id');
        $timesheets = Timesheet::whereNotIn('id', $payrolls)->whereIsClosed(1);
        if ($year_month != null) {
            $timesheets = $timesheets->whereYearMonth($year_month);
        }
        if ($department != null && $department != 'Tất cả phòng ban') {
            $department = Department::whereName($department)->first();
            $timesheets = $timesheets->whereDepartmentId($department->id);
        }
        $timesheets = $timesheets->get();
        return view('pages.payrolls.calculate')->with(compact('timesheets'));
    }

    public function get_kpi(Timesheet $timesheet)
    {
        $kpi = 0;
        $business_result = BusinessResult::whereYearMonth($timesheet->year_month)->first();
        $department_name = $timesheet->department->name;
        switch ($department_name) {
            case 'Điều hành':
                $kpi = $business_result->business_trips_count;
                break;
            case 'Kinh doanh':
                $kpi = $business_result->online_revenue;
                break;
            case 'CS Khách hàng':
                $kpi = $business_result->customer_service_five_stars_percent;
                break;
            case 'Cửa hàng':
                $kpi = $business_result->shop_revenue;
                break;
            default:
                break;
        }
        return $kpi;
    }

    public function get_kpi_bonus_amount($timesheet)
    {
        $kpi = $timesheet->kpi;
        $kpi_bonus_amount = 0;
        $department_name = $timesheet->department->name;
        $position_name = $timesheet->position->name;
        switch ($department_name) {
            case 'Điều hành':
                switch ($position_name) {
                    case 'Giám đốc':
                        $kpi_bonus_amount = 5000000 * $kpi;
                        break;
                    case 'Phó Giám đốc':
                        $kpi_bonus_amount = 3000000 * $kpi;
                        break;
                    default:
                        break;
                }
                break;
            case 'Kinh doanh':
                if ($kpi > 100000000) {
                    switch ($position_name) {
                        case 'Trưởng phòng Kinh doanh':
                            $kpi_bonus_amount = 2000000;
                            break;
                        case 'Nhân viên Kinh doanh Online':
                            $kpi_bonus_amount = 1000000;
                            break;
                        case 'Nhân viên Kế hoạch':
                            $kpi_bonus_amount = 1000000;
                            break;
                        default:
                            break;
                    }
                }
                break;
            case 'CS Khách hàng':
                if ($kpi >= 70) {
                    switch ($position_name) {
                        case 'Trường phòng CS Khách hàng':
                            $kpi_bonus_amount = 8000000;
                            break;
                        case 'Nhân viên CS Khách hàng':
                            $kpi_bonus_amount = 2000000;
                            break;
                        case 'Nhân viên Xử lý khiếu nại':
                            $kpi_bonus_amount = 2000000;
                            break;
                        case 'Nhân viên Kiểm soát chất lượng':
                            $kpi_bonus_amount = 2000000;
                            break;
                        default:
                            break;
                    }
                }
                break;
            case 'Cửa hàng':
                if ($kpi > 2000000000) {
                    switch ($position_name) {
                        case 'Quản lý Cửa hàng':
                            $kpi_bonus_amount = 4000000;
                            break;
                        case 'Nhân viên bán hàng':
                            $kpi_bonus_amount = 2000000;
                            break;
                        case 'Nhân viên Thu ngân':
                            $kpi_bonus_amount = 1000000;
                            break;
                        case 'Nhân viên Kỹ thuật':
                            $kpi_bonus_amount = 500000;
                            break;
                        case 'Nhân viên Bảo vệ':
                            $kpi_bonus_amount = 200000;
                            break;
                        default:
                            break;
                    }
                }
                break;
            default:
                break;
        }
        return $kpi_bonus_amount;
    }
}
