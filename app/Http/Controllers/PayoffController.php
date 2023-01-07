<?php

namespace App\Http\Controllers;

use App\Models\Payoff;

use Illuminate\Http\Request;

class PayoffController extends Controller
{
    public function index()
    {
        $payoffs = Payoff::all();
        return view('pages.payoffs.index')->with(compact('payoffs'));
    }

    public function store(Request $request)
    {
        Payoff::create([
            'year_month' => $request->thang_nam,
            'is_bonus' => $request->loai == 'on',
            'payoff_amount' => (float)filter_var($request->so_tien, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * ($request->loai == 'on' ? 1 : -1),
            'note' => $request->ghi_chu,
            'employee_id' => $request->ma_nhan_vien,
        ]);

        return redirect()->route('payoffs.index')->with('success', 'Tạo thưởng phạt cho nhân viên thành công');
    }

    public function update(Request $request, Payoff $payoff)
    {
        $payoff->update([
            'is_bonus' => $request->loai == 'on',
            'payoff_amount' => (float)filter_var($request->so_tien, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * ($request->loai == 'on' ? 1 : -1),
            'note' => $request->ghi_chu,
        ]);

        return redirect()->route('payoffs.index')->with('success', 'Chỉnh sửa thông tin thưởng phạt cho nhân viên thành công');
    }

    public function destroy(Payoff $payoff)
    {
        $payoff->delete();

        return redirect()->route('payoffs.index')->with('success', 'Xóa thưởng phạt cho nhân viên thành công');
    }
}
