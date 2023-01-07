<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Assignment;

use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        foreach ($positions as $position) {
            $position->assignments = Assignment::whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->wherePositionId($position->id)->get();
        }
        return view('pages.positions.index')->with(compact('positions'));
    }

    public function store(Request $request)
    {
        Position::create([
            'name' => $request->ten_chuc_vu,
            'department_id' => $request->ma_phong_ban,
            'position_allowance_amount' => (float)filter_var($request->phu_cap_chuc_vu, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        ]);

        return redirect()->route('positions.index')->with('success', 'Tạo chức vụ mới thành công');
    }

    public function update(Request $request, Position $position)
    {
        $position->update([
            'name' => $request->ten_chuc_vu,
            'department_id' => $request->ma_phong_ban,
            'position_allowance_amount' => (float)filter_var($request->phu_cap_chuc_vu, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        ]);

        return redirect()->route('positions.index')->with('success', 'Chỉnh sửa thông tin chức vụ thành công');
    }

    public function get_positions(Request $request)
    {
        $positions = Position::whereDepartmentId($request->department_id)->get();
        return $positions;
    }
}
