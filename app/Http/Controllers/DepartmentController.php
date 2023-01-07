<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Assignment;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        foreach ($departments as $department) {
            $department->assignments = Assignment::whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->whereDepartmentId($department->id)->get();
        }
        return view('pages.departments.index')->with(compact('departments'));
    }

    public function store(Request $request)
    {
        Department::create([
            'name' => $request->ten_phong_ban,
        ]);

        return redirect()->route('departments.index')->with('success', 'Tạo phòng ban mới thành công');
    }

    public function update(Request $request, Department $department)
    {
        $department->update([
            'name' => $request->ten_phong_ban,
        ]);

        return redirect()->route('departments.index')->with('success', 'Chính sửa thông tin phòng ban thành công');
    }
}
