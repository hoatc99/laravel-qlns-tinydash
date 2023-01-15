<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\Department;
use App\Models\Position;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Setting;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $year_month = $request->thang_nam;
        $department = $request->phong_ban;
        $timesheets = new Timesheet;
        if ($year_month != null) {
            $timesheets = $timesheets->whereYearMonth($year_month);
        }
        if ($department != null && $department != '') {
            $department = Department::whereName($department)->first();
            $timesheets = $timesheets->whereDepartmentId($department->id);
        }
        $timesheets = $timesheets->get();
        return view('pages.timesheets.index')->with(compact('timesheets'));
    }

    public function create(Request $request)
    {
        if (Session::has('assignment_ids')) {
            $year_month = Session::get('year_month');
            $assignment_ids = Session::get('assignment_ids');
            $assignments = Assignment::whereIn('id', $assignment_ids)->get();
            $start_month = Carbon::createFromFormat('Y-m-d', $year_month . '-' . 1);
            $end_month = Carbon::createFromFormat('Y-m-d', $year_month . '-' . $start_month->daysInMonth);
            foreach ($assignments as $assignment) {
                $assignment->business_days = $this->get_business_days($year_month, 1, $start_month->daysInMonth);
            }
            Session::put('assignments', $assignments);
            return view('pages.timesheets.create')->with(compact('assignments'));
        }
        Session::flash('failed', 'Không tìm thấy danh sách nhân viên cần chấm công');
        return redirect()->route('timesheets.timekeeping');
    }

    public function store(Request $request)
    {
        $assignments = Session::get('assignments');
        for ($i = 0; $i < count($request->maphancong); $i++) {
            $working_days = $request->ngaycongchuan[$i] - $request->nghiphep[$i] - $request->nghikhongphep[$i];
            $data = [
                'year_month' => Session::get('year_month'),
                'business_days_in_month' => $request->ngaycongchuan[$i],
                'business_days' => $request->ngaycongchuan[$i],
                'working_days' => $working_days,
                'leave_days' => $request->nghiphep[$i] ?? 0,
                'unauthorized_leave_days' => $request->nghikhongphep[$i] ?? 0,
                'note' => $request->ghichu[$i] ?? '',
                'assignment_id' => $assignments[$i]['id'],
                'employee_id' => $assignments[$i]['employee_id'],
                'department_id' => Position::whereId($assignments[$i]['position_id'])->first()->department->id,
                'position_id' => $assignments[$i]['position_id'],
            ];
            Timesheet::create($data);
        }
        Session::flash('success', 'Chấm công hoàn tất');
        return redirect()->route('timesheets.index');
    }

    public function show(Timesheet $timesheet)
    {
        //
    }

    public function edit(Timesheet $timesheet)
    {
        return view('pages.timesheets.edit')->with(compact('timesheet'));
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        //
    }

    public function destroy(Timesheet $timesheet)
    {
        //
    }

    public function print_all(Timesheet $timesheet)
    {
        //
    }

    public function print_single(Timesheet $timesheet)
    {
        //
    }

    public function send_timekeeping_request(Request $request)
    {
        $assignments = $request->phan_cong;
        $assignment_ids = array();
        foreach ($assignments as $id => $state) {
            if ($state == 'on') {
                $assignment_ids[] = $id;
            }
        }
        Session::put('assignment_ids', $assignment_ids);
        Session::put('year_month', $request->thang_nam);
        return redirect()->route('timesheets.create');
    }

    // public function timekeeping(Request $request)
    // {
    //     $employees = new Employee;
    //     if (isset($request->thang_nam)) {
    //         $keeping_day = 6;
    //         $today = Carbon::create(2022, 12, 2);
    //         $year = explode('-', $request->thang_nam)[0];
    //         $month = explode('-', $request->thang_nam)[1];
    //         $start_month = Carbon::create($year, $month, 1);
    //         $end_month = Carbon::create($year, $month, $start_month->daysInMonth);
    //         $start_keeping_date = Carbon::create($year, $month, 1)->addMonth();
    //         $end_keeping_date = Carbon::create($year, $month, 1)->addMonth()->addDay($keeping_day);
    //         if ($today >= $start_keeping_date && $today < $end_keeping_date) {
    //             Session::forget('failed');
    //             $assignment_employee_ids = Assignment::active()->pluck('employee_id');
    //             $timesheet_employee_ids = Timesheet::where(['year' => $year, 'month' => $month])->pluck('employee_id');
    //             $employees = $employees->whereNotIn('id', $timesheet_employee_ids);
    //             $employees = $employees->whereIn('id', $assignment_employee_ids);
    //             $employees = $employees->where('date_of_employment', '>=', $start_month);
    //             $employees = $employees->get();
    //         } else if ($today >= $end_keeping_date) {
    //             Session::flash('failed', 'Đã quá hạn chấm công');
    //             $employees = null;
    //         } else if ($today < $start_keeping_date) {
    //             Session::flash('failed', 'Chưa đến kỳ chấm công');
    //             $employees = null;
    //         }
    //     }
    //     else
    //     {
    //         Session::flash('failed', 'Vui lòng chọn kỳ chấm công');
    //         $employees = null;
    //     }
    //     return view('pages.timesheets.timekeeping')->with(compact('employees'));
    // }

    public function timekeeping(Request $request)
    {
        $assignments = array();
        $departments = Department::all();
        if (isset($request->thang_nam)) {
            $year_month = $request->thang_nam;
            $timekeeping_status = $this->get_timekeeping_status($year_month);
            if ($timekeeping_status == 0) {
                Session::forget('failed');
                $department = $request->phong_ban;
                $start_month = Carbon::createFromFormat('Y-m-d', $year_month . '-' . 1);
                $end_month = Carbon::createFromFormat('Y-m-d', $year_month . '-' . $start_month->daysInMonth);
                $timesheet_employee_ids = Timesheet::whereYearMonth($year_month)->pluck('employee_id');
                $assignments = Assignment::where('start_date', '<=', $end_month)->where('actual_end_date', '>=', $start_month)->whereNotIn('employee_id', $timesheet_employee_ids);
                if ($department != null && $department != 'Tất cả phòng ban') {
                    $department = Department::whereName($department)->first();
                    $position_ids = Position::whereDepartmentId($department->id)->pluck('id');
                    $assignments = $assignments->whereIn('position_id', $position_ids);
                }
                $assignments = $assignments->get();
            } else if ($timekeeping_status == 1) {
                Session::flash('failed', 'Đã quá hạn chấm công, vui lòng liên hệ IT để được hỗ trợ');
            } else if ($timekeeping_status == -1) {
                Session::flash('failed', 'Chưa đến kỳ chấm công');
            }
        } else {
            Session::flash('failed', 'Vui lòng chọn kỳ chấm công');
        }
        return view('pages.timesheets.timekeeping')->with(compact('assignments', 'departments'));
    }

    public function show_timesheets_to_close(Request $request)
    {
        $timesheets = Timesheet::whereIsClosed(0);
        $year_month = $request->thang_nam;
        if ($request->thang_nam != null) {
            $timesheets = $timesheets->whereYearMonth($year_month);
        }
        $department = $request->phong_ban;
        if ($department != null && $department != 'Tất cả phòng ban') {
            $department = Department::whereName($department)->first();
            $timesheets = $timesheets->whereDepartmentId($department->id);
        }
        $timesheets = $timesheets->get();
        return view('pages.timesheets.close')->with(compact('timesheets'));
    }

    public function close_timesheets(Request $request)
    {
        // Tiến hành chốt bảng công
        $timesheets = $request->bang_cong;
        foreach ($timesheets as $id => $state) {
            if ($state == 'on') {
                $timesheet_ids[] = $id;
            }
        }
        Timesheet::whereIn('id', $timesheet_ids)->update([
            'is_closed' => 1,
        ]);
        return redirect()->route('timesheets.index')->with('success', 'Chốt bảng công hoàn tất!');
    }

    public function get_timekeeping_status($year_month)
    {
        $today = Carbon::createFromFormat('Y-m-d', Setting::first()->virtual_today);
        $days_for_timekeeping = Setting::first()->days_for_timekeeping;
        $start_keeping_date = Carbon::createFromFormat('Y-m-d', $year_month . '-' . 1)->addMonth();
        $end_keeping_date = Carbon::createFromFormat('Y-m-d', $year_month . '-' . 1)->addMonth()->addDay($days_for_timekeeping);
        $is_overdue_timesheet_timekeeping_open = Setting::first()->is_overdue_timesheet_timekeeping_open;
        if ($today >= $start_keeping_date && $today < $end_keeping_date || $is_overdue_timesheet_timekeeping_open) {
            // Được chấm công
            return 0;
        } else if ($today >= $end_keeping_date && !$is_overdue_timesheet_timekeeping_open) {
            // Quá hạn chấm công
            return 1;
        } else if ($today < $start_keeping_date) {
            // Chưa đến hạn chấm công
            return -1;
        }
    }

    public function get_business_days($year_month, $start = 1, $end = null)
    {
        $business_days = 0;
        $daysInMonth = $end ?? Carbon::createFromFormat('Y-m', $year_month)->daysInMonth;
        for ($i = $start; $i <= $daysInMonth; $i++) {
            if (date('N', strtotime($year_month . '-' . $i)) < 7) {
                $business_days++;
            }
        }
        return $business_days;
    }
}
