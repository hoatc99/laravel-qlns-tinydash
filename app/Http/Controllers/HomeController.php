<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Setting;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $employee = Employee::find(Auth::id());
        return view('pages.home')->with(compact('employee'));
    }

    public function login()
    {
        if (Auth::check()) {
            Session::flash('success', 'Bạn đã đăng nhập');
            return redirect()->route('home');
        }
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $data = [
            'username' => $request->ten_dang_nhap,
            'password' => $request->mat_khau,
            'is_active' => 1,
        ];
        if (Auth::attempt($data)) {
            return redirect()->route('home');
        } else {
            Session::flash('failed', 'Tên tài khoản hoặc mật khẩu không đúng!');
            return redirect()->route('login');
        }
    }

    public function forgot()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.forgot');
    }

    public function confirm()
    {
        return view('pages.auth.confirm');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function settings()
    {
        $setting = Setting::first();
        return view('pages.settings')->with(compact('setting'));
    }

    public function save_settings(Request $request)
    {
        Setting::first()->update([
            'parking_allowance_amount' => (float)filter_var($request->phu_cap_gui_xe, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'sleep_at_shop_allowance_amount' => (float)filter_var($request->phu_cap_truc_sieu_thi, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'seniority_allowance_percent' => $request->phu_cap_tham_nien,
            'days_for_timekeeping' => $request->so_ngay_cham_cong,
            'days_for_payroll_calculate' => $request->so_ngay_tinh_luong,
            'is_overdue_timesheet_timekeeping_open' => $request->mo_cham_cong_qua_han,
            'is_overdue_payroll_calculate_open' => $request->mo_tinh_luong_qua_han,
            'init_basic_pay_amount' => (float)filter_var($request->khoi_tao_luong_co_ban, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'virtual_today' => Carbon::createFromFormat('d/m/Y', $request->gia_lap_ngay_hom_nay)->format('Y-m-d'),
        ]);
        
        return redirect()->route('settings')->with('success', 'Cập nhật cài đặt hệ thống thành công');
    }
}
