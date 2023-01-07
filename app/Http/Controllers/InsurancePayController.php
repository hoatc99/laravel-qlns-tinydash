<?php

namespace App\Http\Controllers;

use App\Models\InsurancePay;

use Illuminate\Http\Request;

class InsurancePayController extends Controller
{
    public function index(Request $request)
    {
        $year_month = $request->thang_nam;
        $insurance_pays = new InsurancePay;
        if ($year_month != null) {
            $insurance_pays = $insurance_pays->whereYearMonth($year_month);
        }
        $insurance_pays = $insurance_pays->latest()->get();
        foreach ($insurance_pays as $insurance_pay) {
            $insurance_pay->sum_of_insurances_amount = $insurance_pay->social_insurance_pay_amount + $insurance_pay->health_insurance_pay_amount + $insurance_pay->unemployment_insurance_pay_amount;
        }
        return view('pages.insurance_pays.index')->with(compact('insurance_pays'));
    }
}
