<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AdminReportHelperController extends Controller
{
    //
    static function generatePdfMonthlySavings($currentYear,$balanceBroughtForward,$monthlySavings,$totalDeposit)
    {
        $pdf = PDF::loadView('dashboard/admin/reports/monthlyIncomeStatement',
            compact('monthlySavings', 'currentYear','totalDeposit','balanceBroughtForward'));
        return $pdf->download('totalSavingAccountStatement.pdf');
    }
}
