<?php

namespace App\Http\Controllers;

use App\Models\Advance;

use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index()
    {
        $advances = Advance::all();
        return view('pages.advances.index')->with(compact('advances'));
    }

    public function store(Request $request)
    {
        Advance::create([
            'year_month' => $request->thang_nam,
            'advance_amount' => (float)filter_var($request->so_tien, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * (-1),
            'note' => $request->ghi_chu,
            'employee_id' => $request->ma_nhan_vien,
        ]);

        return redirect()->route('advances.index')->with('success', 'Tạo tạm ứng cho nhân viên thành công');
    }

    public function update(Request $request, Advance $advance)
    {
        $advance->update([
            'advance_amount' => (float)filter_var($request->so_tien, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) * (-1),
            'note' => $request->ghi_chu,
        ]);

        return redirect()->route('advances.index')->with('success', 'Chỉnh sửa thông tin tạm ứng cho nhân viên thành công');
    }

    public function destroy(Advance $advance)
    {
        $advance->delete();

        return redirect()->route('advances.index')->with('success', 'Xóa tạm ứng cho nhân viên thành công');
    }
}
