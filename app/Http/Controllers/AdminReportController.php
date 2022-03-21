<?php

namespace App\Http\Controllers;

use App\Appropriation;
use App\ChartOfAccount;
use App\Expense;
use App\Exports\AdminExpenseReport;
use App\Exports\AdminGenerateGeneralLedger;
use App\Exports\AdminGenerateYearlyDividend;
use App\Exports\AdminMemberTransactionReport;
use App\Exports\AdminMonthlyApprovedLoanExports;
use App\Exports\AdminMonthlyGroupedIncomeExports;
use App\Exports\AdminMonthlyIncomeWithSourceExports;
use App\Exports\AdminMonthlyLoanFeesExports;
use App\Exports\AdminMonthlyRecoveredLoanExports;
use App\Exports\AdminMonthlySavingsAccountExports;
use App\Exports\AdminMonthlyWithdrawalAccountExports;
use App\Loan;
use App\Saving;
use App\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{

    public function renderReportFilter()
    {
        $journals = DB::table('chart_of_accounts')->select('id','name','code')->get();
        return view('dashboard.admin.reports.adminReportFilter',compact('journals'));
    }

    public function generateReports(Request $request)
    {
        //consolidated_earning
        if($request->report_type == 'monthly_deposits' && $request->pdf) {
            return $this->generatePdfMonthlySavings($request);
        }elseif ($request->report_type == 'monthly_deposits' && $request->excel){
            return $this->generateExcelMonthlySavings($request);
        }elseif ($request->report_type == 'monthly_drawings' && $request->pdf){
            return $this->generatePdfMonthlyWithdrawalStatement($request);
        }elseif ($request->report_type == 'monthly_drawings' && $request->excel){
            return $this->generateExcelMonthlyWithdrawalStatement($request);
        }elseif ($request->report_type == 'monthly_loan_fees' && $request->pdf){
            return $this->generatePdfLoanFees($request);
        }elseif ($request->report_type == 'monthly_loan_fees' && $request->excel) {
            return $this->generateExcelLoanFees($request);
        }elseif ($request->report_type == 'monthly_loan_approved' && $request->pdf){
            return $this->generatePdfMonthlyApprovedLoan($request);
        }elseif ($request->report_type == 'monthly_loan_approved' && $request->excel) {
            return $this->generateExcelMonthlyApprovedLoan($request);
        }elseif ($request->report_type == 'monthly_loan_recovered' && $request->pdf){
            return $this->generatePdfMonthlyRecoveredLoan($request);
        }elseif ($request->report_type == 'monthly_loan_recovered' && $request->excel) {
            return $this->generateExcelMonthlyRecoveredLoan($request);
        }elseif ($request->report_type == 'monthly_income_with_sources' && $request->pdf){
            return $this->generatePdfMonthlyIncomeWithSources($request);
        }elseif ($request->report_type == 'monthly_income_with_sources' && $request->excel) {
            return $this->generateExcelMonthlyIncomeWithSources($request);
        }elseif($request->report_type == 'yearly_grouped_income' && $request->pdf){
            return $this->generatePdfMonthlyGroupedIncome($request);
        }elseif($request->report_type == 'yearly_grouped_income' && $request->excel) {
            return $this->generateExcelMonthlyGroupedIncome($request);
        }elseif($request->report_type == 'general_ledger' && $request->pdf) {
            return $this->generatePDFGeneralLedger($request);
        }elseif($request->report_type == 'general_ledger' && $request->excel) {
            return $this->generateExcelGeneralLedger($request);
        }elseif($request->report_type == 'expense_report' && $request->pdf) {
            return $this->generatePDFExpenseReport($request);
        }elseif($request->report_type == 'expense_report' && $request->excel) {
            return $this->generateExcelExpenseReport($request);
        }elseif($request->report_type == 'members_transactions' && $request->pdf) {
            return $this->generatePDFMembersTransaction($request);
        }elseif($request->report_type == 'members_transactions' && $request->excel) {
            return $this->generateExcelMembersTransaction($request);
        }elseif($request->report_type == 'declared_dividends' && $request->pdf) {
            return $this->generatePdfDeclaredDividend($request);
        }elseif($request->report_type == 'declared_dividends' && $request->excel) {
            return $this->generateExcelDeclaredDividend($request);
        }

    }

    private function generatePdfMonthlySavings(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            $previousYear = $currentYear - 1;
            //get the balance brought forward
            $balanceBroughtForward = Saving::where('month','LIKE','%'.$previousYear.'%')->sum('amount_saved');
            //monthly members' deposits
            $monthlySavings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_saved) amount_saved'))
                ->where('description','!=','Savings Withdrawal')
                ->whereBetween('month',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
            $totalDeposit = 0;
            foreach ($monthlySavings as $monthlySaving){
                $totalDeposit = $totalDeposit + $monthlySaving->amount_saved;
            }
            if ($monthlySavings) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlySavingsAccountStatement',
                    compact('monthlySavings', 'currentYear','totalDeposit','balanceBroughtForward','startDate','endDate'));
                Toastr::success('Total Savings Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlySavingsAnalysisFor'.$startDate.'-'.$endDate.'.pdf');
                return redirect()->back();
            }else {
                Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlySavings(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            $previousYear = $currentYear - 1;
            return (new AdminMonthlySavingsAccountExports($currentYear,$previousYear,$startDate,$endDate))->download('monthlySavingsAnalysisFor'.$startDate.'-'.$endDate.'.xlsx');

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generatePdfMonthlyWithdrawalStatement(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            //monthly members' drawings
            $monthlyDrawings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_withdrawn) amount_withdrawn'))
                //->where([['month','LIKE','%'.$currentYear.'%'],['description','=','Savings Withdrawal']])
                ->where('description','=','Savings Withdrawal')
                ->whereBetween('month',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
            $totalDrawings = 0;
            foreach ($monthlyDrawings as $monthlyDrawing){
                $totalDrawings = $totalDrawings + $monthlyDrawing->amount_withdrawn;
            }

            if (count($monthlyDrawings) > 0 ) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlyWithdrawalStatement',
                    compact('currentYear','monthlyDrawings','totalDrawings','startDate','endDate'));
                Toastr::success('Withdrawal statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlyWithdrawalAnalysisFor'.$startDate.'-'.$endDate.'.pdf');
            }else {
                Toastr::warning('No loan(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlyWithdrawalStatement(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            return (new AdminMonthlyWithdrawalAccountExports($currentYear,$startDate,$endDate))->download('monthlyWithdrawalAnalysisFor'.$startDate.'-'.$endDate.'.xlsx');

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generatePdfLoanFees(Request $request)
    {
        if($request->date_range != null)
        {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));
            $currentYear = date('Y');
            //get the current loan fees
            $monthlyLoanFees = DB::table('incomes')->SELECT(DB::raw('income_type'),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
                //->where([['created_at','LIKE','%'.$currentYear.'%'],['income_type','=','Loan Application Fees']])
                ->where('income_type','=','Loan Application Fees')
                ->whereBetween('created_at',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
            $totalLoanFees = 0;
            foreach ($monthlyLoanFees as $monthlyLoanFee){
                $totalLoanFees = $totalLoanFees + $monthlyLoanFee->income_realized;
            }
                if ($monthlyLoanFees) {
                    $pdf = PDF::loadView('dashboard/admin/reports/monthlyLoanFeesAnalysis',
                        compact('monthlyLoanFees', 'currentYear','totalLoanFees'));
                    Toastr::success('Total loan fees analysis downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                    return $pdf->download('monthlyLoanAnalysisFor'.$startDate.'-'.$endDate.'.pdf');
                }else {
                    Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                    return redirect()->bacK();
                }
           }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelLoanFees(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            return (new AdminMonthlyLoanFeesExports($startDate, $endDate))->download('monthlyLoanFeesAnalysisFor'.$startDate.'-'.$endDate.'.xlsx');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generatePdfMonthlyApprovedLoan(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            $previousYear = $currentYear - 1;

            //get the balance brought forward
            $loanBalBroughtForward = Loan::where([['created_at','LIKE','%'.$previousYear.'%'],['status','=','Approved']])->sum('loan_amount');
            //get monthly approved loan
            $monthlyApprovedLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(loan_amount) loan_amount'))
                //->where([['created_at','LIKE','%'.$currentYear.'%'],['status','=','Approved']])
                ->where('status','=','Approved')
                ->whereBetween('created_at',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('month_year'))->get();
            $totalApprovedLoan = 0;
            foreach ($monthlyApprovedLoans as $monthlyApprovedLoan){
                $totalApprovedLoan = $totalApprovedLoan + $monthlyApprovedLoan->loan_amount;
            }

            if (count($monthlyApprovedLoans) > 0) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlyApprovedLoansAnalysis',
                    compact('monthlyApprovedLoans','totalApprovedLoan','loanBalBroughtForward','startDate','endDate'));
                Toastr::success('Monthly approved Loan successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlyApprovedLoanAnalysisFor'.$startDate.'-'.$endDate.'.pdf');
            }else{
                Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlyApprovedLoan(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            $previousYear = $currentYear - 1;
            return (new AdminMonthlyApprovedLoanExports($currentYear,$previousYear,$startDate,$endDate))->download('monthlyApprovedLoanAnalysisFor'.$startDate.'-'.$endDate.'.xlsx');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generatePdfMonthlyRecoveredLoan(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $currentYear = date('Y');
            //get monthly recovered loan
            $monthlyRecoveredLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(amount_recovered) amount_recovered'))
                //->where([['created_at','LIKE','%'.$currentYear.'%'],['status','!=','Processing'],['status','!=','Rejected']])
                ->where('status','!=','Processing')
                ->where('status','!=','Rejected')
                ->whereBetween('created_at',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('month_year'))->get();
            $totalRecoveredLoan = 0;
            foreach ($monthlyRecoveredLoans as $monthlyRecoveredLoan){
                $totalRecoveredLoan = $totalRecoveredLoan + $monthlyRecoveredLoan->amount_recovered;
            }
            if (count($monthlyRecoveredLoans) > 0) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlyRecoveredLoansAnalysis',
                    compact('monthlyRecoveredLoans','totalRecoveredLoan','startDate','endDate'));
                Toastr::success('Recovered analysis loan successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlyApprovedLoanForAnalysis'.$startDate.'-'.$endDate.'.pdf');
            }else{
                Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlyRecoveredLoan(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            return (new AdminMonthlyRecoveredLoanExports($startDate,$endDate))->download('monthlyRecoveredLoanAnalysisFor'.$startDate.'-'.$endDate.'.xlsx');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generatePdfMonthlyIncomeWithSources(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            //get monthly income with sources
            $monthlyIncomes = DB::table('incomes')->SELECT(DB::raw("DATE_FORMAT(created_at,'%Y-%m') recorded_on"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
                //->where([['created_at','LIKE','%'.$currentYear.'%']])
                ->whereBetween('created_at',[$startDate,$endDate])
                ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
            $totalMonthlyIncome = 0;
            foreach ($monthlyIncomes as $monthlyIncome){
                $totalMonthlyIncome = $totalMonthlyIncome + $monthlyIncome->income_realized;
            }
            if (count($monthlyIncomes) > 0) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlyIncomeWithSourcesAnalysis',
                    compact('monthlyIncomes','totalMonthlyIncome','startDate','endDate'));
                Toastr::success('Monthly income analysis successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlyIncomeWithSourcesAnalysis'.$startDate.'-'.$endDate.'.pdf');
            }else{
                Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlyIncomeWithSources(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            return (new AdminMonthlyIncomeWithSourceExports($startDate,$endDate))->download('monthlyIncomeWithSourcesFor'.$startDate.'-'.$endDate.'.xlsx');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generatePdfMonthlyGroupedIncome(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startYear = date("Y", strtotime($rawStartDate));
            $endYear = date("Y", strtotime($rawEndDate));
            $currentYear = date('Y');
            //income grouping
            $incomeGroupings = DB::table('incomes')->SELECT(DB::raw("DATE_FORMAT(created_at, '%Y') year"),DB::raw('SUM(income_realized) income_realized'))
                ->where([['created_at','LIKE','%'.$startYear.'%']])
                ->Orwhere([['created_at','LIKE','%'.$endYear.'%']])
                //->whereBetween('created_at',[$startYear,$endDYear])
                ->groupBy(DB::raw('year'))->get();

            $totalGroupedIncome = 0;
            foreach ($incomeGroupings as $incomeGrouping){
                $totalGroupedIncome = $totalGroupedIncome + $incomeGrouping->income_realized;
            }
            if (count($incomeGroupings) > 0) {
                $pdf = PDF::loadView('dashboard/admin/reports/monthlyGroupedIncomeAnalysis',
                    compact('incomeGroupings','totalGroupedIncome','startYear','endYear'));
                Toastr::success('Monthly grouped income successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('monthlyGroupedIncomeAnalysis'.$startYear.'-'.$endYear.'.pdf');
            }else{
                Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();
            }

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelMonthlyGroupedIncome(Request $request)
    {
        if($request->date_range != null) {
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startYear = date("Y", strtotime($rawStartDate));
            $endYear = date("Y", strtotime($rawEndDate));

            return (new AdminMonthlyGroupedIncomeExports($startYear,$endYear))->download('monthlyIncomeWithSourcesFor'.$startYear.'-'.$endYear.'.xlsx');


        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generatePDFGeneralLedger(Request $request)
    {
        if($request->journals != null || $request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

             $chartOfAccounts = ChartOfAccount::whereIn('id',$request->journals)->select('id','code','type_id','name')->get();
                $pdf = PDF::loadView('dashboard/admin/reports/generalLedger',compact('chartOfAccounts','startDate','endDate'));
                Toastr::success('Ledger successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
                return $pdf->download('coopGeneralLedger'.now().'.pdf');
        }else{
            Toastr::warning('Select at least a journal and a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generateExcelGeneralLedger(Request $request)
    {
        if($request->journals != null || $request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));
            $chartOfAccountIDs = $request->journals;
            return ( new AdminGenerateGeneralLedger($startDate,$endDate,$chartOfAccountIDs))->download('CoopGeneralLedger'.now().'.xlsx');
        }else{
            Toastr::warning('Select at least a journal and a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    public function generatePDFExpenseReport(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $coopExpenses = Expense::whereBetween('created_at', [$startDate, $endDate])->get();
            $totalExpense = 0;
            foreach ($coopExpenses as $coopExpense){
                $totalExpense = $totalExpense + $coopExpense->total_price;
            }

            $pdf = PDF::loadView('dashboard/admin/reports/expenseReport',compact('coopExpenses','startDate','endDate','totalExpense'));
            Toastr::success('Expense Report successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $pdf->download('expenseReport'.now().'.pdf');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function generateExcelExpenseReport(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            return ( new AdminExpenseReport($startDate,$endDate))->download('CoopExpenseReport'.now().'.xlsx');

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function generatePDFMembersTransaction(Request $request)
    {
        //dd($request->all());
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $memberTotalTransactions = Transaction::with('users')->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('user_id, sum(transaction_amount) as total_transaction')
                ->groupBy('user_id')->get();
            $totalTransaction = 0;
            foreach ($memberTotalTransactions as $memberTotalTransaction){
                $totalTransaction = $totalTransaction + $memberTotalTransaction->total_transaction;
            }

            $pdf = PDF::loadView('dashboard/admin/reports/memberTransactionsReport',compact('memberTotalTransactions','startDate','endDate','totalTransaction'));
            Toastr::success('Member Transaction successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $pdf->download('membersTransactionReport'.now().'.pdf');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function generateExcelMembersTransaction(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

        return (new AdminMemberTransactionReport($startDate,$endDate))->download('membersTransactionReport'.now().'.xlsx');

        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generatePdfDeclaredDividend(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            $declaredDividends = Appropriation::whereBetween('created_at', [$startDate, $endDate])->groupBy('financial_year')->orderByDESC('id')->get();

            $pdf = PDF::loadView('dashboard/admin/reports/declaredDividends',compact('declaredDividends','startDate','endDate'));
            Toastr::success('Declared Dividends successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $pdf->download('declaredDividends'.now().'.pdf');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelDeclaredDividend(Request $request)
    {
        if($request->date_range != null){
            $dateObj = strtr($request->date_range, '/', '-');
            $rawStartDate = substr($dateObj, 0, 10);
            $rawEndDate = substr($dateObj, 12, 23);
            $startDate = date("Y-m-d", strtotime($rawStartDate));
            $endDate = date("Y-m-d", strtotime($rawEndDate));

            return (new AdminGenerateYearlyDividend($startDate,$endDate))->download('yearlyDeclaredDividend'.$startDate.'-'.$endDate.'.xlsx');
        }else{
            Toastr::warning('Select a date range', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }


}
