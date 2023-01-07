<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assignment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->assignment = Assignment::whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->whereEmployeeId($user->employee->id)->first();
        }
        return view('pages.users.index')->with(compact('users'));
    }

    public function store(Request $request)
    {
        User::create([
            'username' => $request->ten_tai_khoan,
            'password' => bcrypt($request->mat_khau),
            'role' => $request->quyen,
            'employee_id' => $request->ma_nhan_vien,
        ]);

        return redirect()->back()->with('success', 'Tạo tài khoản thành công');
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function set_permission(Request $request, $user_id)
    {
        User::whereId($user_id)->update(['role' => $request->quyen]);
        Session::flash('success', 'Đã cập nhật quyền cho tài khoản');
        return redirect()->route('users.index');
    }

    public function lock($user_id)
    {
        User::whereId($user_id)->update(['is_active' => 0]);
        Session::flash('success', 'Đã khóa tài khoản');
        return redirect()->route('users.index');
    }

    public function unlock($user_id)
    {
        User::whereId($user_id)->update(['is_active' => 1]);
        Session::flash('success', 'Đã mở khóa tài khoản');
        return redirect()->route('users.index');
    }
}
