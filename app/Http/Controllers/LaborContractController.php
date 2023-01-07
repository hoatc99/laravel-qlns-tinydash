<?php

namespace App\Http\Controllers;

use App\Models\LaborContract;

use Illuminate\Http\Request;

class LaborContractController extends Controller
{
    public function index()
    {
        $labor_contracts = LaborContract::all();
        return view('pages.labor_contracts.index')->with(compact('labor_contracts'));
    }

    public function store(Request $request)
    {
        LaborContract::create([
            'name' => $request->ten_phong_ban,
            'description' => $request->mo_ta,
        ]);

        return redirect()->route('departments.index')->with('success', 'Tạo hợp đồng lao động mới thành công');
    }

    public function update(Request $request, LaborContract $labor_contract)
    {
        $labor_contract->update([
            
        ]);

        return redirect()->route('departments.index')->with('success', 'Chính sửa hợp đồng lao động thành công');
    }
}
