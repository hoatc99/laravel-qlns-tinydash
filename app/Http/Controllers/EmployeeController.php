<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Assignment;
use App\Models\LaborContract;
use App\Models\BasicPay;
use App\Models\Setting;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        foreach ($employees as $employee) {
            $employee->assignment = Assignment::whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->whereEmployeeId($employee->id)->first();
        }
        return view('pages.employees.index')->with(compact('employees'));
    }

    public function create()
    {
        return view('pages.employees.create_edit');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::create([
                'fullname' => $request->ho_va_ten,
                'date_of_birth' => $request->ngay_sinh,
                'gender' => $request->gioi_tinh,
                'place_of_permanent' => $request->dia_chi,
                'identification_number' => $request->so_cccd,
                'date_of_issue' => $request->ngay_cap,
                'place_of_issue' => $request->noi_cap,
                'phone_number' => $request->so_dien_thoai,
                'email' => $request->email,
                'date_of_employment' => $request->ngay_nhan_viec,
                'is_marital' => $request->tinh_trang_hon_nhan,
                'academic_level' => $request->trinh_do_hoc_van,
                'qualification' => $request->trinh_do_chuyen_mon,
                'social_insurance_number' => $request->ma_bhxh,
                'avatar_url' => $this->store_avatar($request->anh_dai_dien),
                'additional_infomation' => $request->thong_tin_them,
            ]);

            BasicPay::create([
                'basic_pay_amount' => Setting::first()->init_basic_pay_amount,
                'start_date' => $request->ngay_nhan_viec,
                'employee_id' => $employee->id,
            ]);
            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Tạo nhân viên mới thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('success', 'Tạo nhân viên thất bại')->withError($e->getMessage())->withInput();
        }
    }

    public function show(Employee $employee)
    {
        $employee->assignment = Assignment::whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->whereEmployeeId($employee->id)->first();
        $employee->assignments = Assignment::whereEmployeeId($employee->id)->latest()->get();
        foreach ($employee->assignments as $assignment) {
            $assignment->is_ended = !$assignment->is_active || $assignment->actual_end_date > today();
        }
        $employee->basic_pay = BasicPay::whereIsActive(1)->whereEmployeeId($employee->id)->first();
        $employee->labor_contracts = LaborContract::whereEmployeeId($employee->id)->latest()->get();
        return view('pages.employees.show')->with(compact('employee'));
    }

    public function edit(Employee $employee)
    {
        if ($employee->is_working) {
            return view('pages.employees.create_edit')->with(compact('employee'));
        }
        return redirect()->route('employees.index')->with('failed', 'Nhân viên đã thôi việc, không thể chỉnh sửa thông tin');
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update([
            'fullname' => $request->ho_va_ten,
            'date_of_birth' => $request->ngay_sinh,
            'gender' => $request->gioi_tinh,
            'place_of_permanent' => $request->dia_chi,
            'identification_number' => $request->so_cccd,
            'date_of_issue' => $request->ngay_cap,
            'place_of_issue' => $request->noi_cap,
            'phone_number' => $request->so_dien_thoai,
            'email' => $request->email,
            'date_of_employment' => $request->ngay_nhan_viec,
            'is_marital' => $request->tinh_trang_hon_nhan,
            'academic_level' => $request->trinh_do_hoc_van,
            'qualification' => $request->trinh_do_chuyen_mon,
            'social_insurance_number' => $request->ma_bhxh,
            'avatar_url' => $this->store_avatar($request->anh_dai_dien, $employee),
            'additional_infomation' => $request->thong_tin_them,
        ]);

        return redirect()->route('employees.index')->with('success', 'Chỉnh sửa thông tin nhân viên thành công');
    }

    public function print_all(Employee $employee)
    {
        return view('reports.all_employees');
    }

    public function print_single(Employee $employee)
    {
        //
    }

    public function assign(Request $request, Employee $employee)
    {
        Assignment::whereEmployeeId($employee->id)->update([
            'is_active' => 0,
            'actual_end_date' => today(),
        ]);

        Assignment::create([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->ngay_bat_dau)->format('Y-m-d'),
            'expected_end_date' => Carbon::createFromFormat('d/m/Y', $request->ngay_ket_thuc)->format('Y-m-d'),
            'actual_end_date' => Carbon::createFromFormat('d/m/Y', $request->ngay_ket_thuc)->format('Y-m-d'),
            'is_parking_allowance' => in_array('gui_xe', $request->allowances),
            'is_sleep_at_shop_allowance' => in_array('truc_sieu_thi', $request->allowances),
            'employee_id' => $employee->id,
            'department_id' => $request->ma_phong_ban,
            'position_id' => $request->ma_chuc_vu,
        ]);

        return redirect()->route('employees.index')->with('alert', 'Phân công cho nhân viên thành công');
    }

    public function change_basic_pay(Request $request, Employee $employee)
    {
        BasicPay::active()->whereEmployeeId($employee->id)->update(['is_active' => 0]);

        BasicPay::create([
            'basic_pay_amount' => $request->luong_co_ban,
            'start_date' => $request->ngay_bat_dau,
            'employee_id' => $employee->id,
        ]);

        return redirect()->route('employees.index')->with('alert', 'Cập nhật lương cơ bản cho nhân viên thành công');
    }

    public function store_avatar($avatar_tmp_url, $employee = null)
    {
        $destination_path = 'upload/avatars/';
        if ($employee && $avatar_tmp_url == null) {
            return $employee->avatar_url;
        }
        if ($avatar_tmp_url) {
            return 'face.png';
        }
        $extension = $avatar_tmp_url->getClientOriginalExtension();
        $new_name = date('Ymdhis') . time() . rand(11111, 99999);
        $avatar_url = $new_name . '.' . $extension;
        $avatar_tmp_url->move($destination_path, $avatar_url);
        return $avatar_url;
    }

    public function update_status(Request $request, Employee $employee)
    {
    }
}
