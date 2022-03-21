<?php

namespace App\Http\Controllers;

use App\Dividend;
use App\Exports\ExcelFilteredAccountStatement;
use App\Exports\ExcelFilteredLoanStatement;
use App\Exports\ExcelFilteredTransactionStatement;
use App\Loan;
use App\Saving;
use App\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Toaster;



class UserReportController extends Controller
{
    public function renderUserReportTemplate()
    {
        return view('dashboard/reports/user/userReportTemplate');
    }
    //generate account statement
    public function generateAccountStatement(){
        $savings = Saving::where('user_id',Auth::id())->orderBy('id','desc')->get();
        $total_savings = 0;$total_withdrawal = 0;
        foreach ($savings as $saving){
            if($saving->description == 'Monthly Savings'){
                $total_savings = $total_savings + $saving->amount_saved;
            }elseif($saving->description == 'Savings Withdrawal'){
                $total_withdrawal = $total_withdrawal + $saving->amount_withdrawn;
            }
        }
        $pdf = PDF::loadView('dashboard/reports/user/accountStatement', compact('savings','total_savings','total_withdrawal'));
        // return $pdf->save('path of your directory/filename.pdf');
        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Savings Account Statement');
        return $pdf->download(Auth::user()->ippis_no.'/Account Statement.pdf');
    }

    public function generateLoanStatementFromLink()
    {
        $loans = Loan::with('installments')->where([['user_id','=',Auth::id()], ['status','!=','Processing']])->get();
        $pdf = PDF::loadView('dashboard/reports/user/loanStatementFromLink', compact('loans'));
        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Loan Account Statement');
        return $pdf->download(Auth::user()->ippis_no.'/Loan Statement.pdf');

    }

    public function generateTransactionStatement()
    {
        $transactions = Transaction::where([['user_id','=',Auth::id()]])->get();
        $total_transaction = 0;
        foreach ($transactions as $transaction){
            $total_transaction = $total_transaction + $transaction->transaction_amount;
        }
        $pdf = PDF::loadView('dashboard/reports/user/transactionStatement', compact('transactions','total_transaction'));
        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Transactions Statement');
        return $pdf->download(Auth::user()->ippis_no.'/Transaction Statement.pdf');
    }

    public function printDividends()
    {
        $dividends = Dividend::where('user_id',Auth::id())->get();
        $total_dividends = 0;
        foreach ($dividends as $dividend){
            $total_dividends = $total_dividends + $dividend->total_dividends;
        }
        $pdf = PDF::loadView('dashboard/reports/user/dividends', compact('dividends','total_dividends'));
        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Dividends Statement');
        return $pdf->download(Auth::user()->ippis_no.'/Dividends.pdf');
    }

    public function generateUserReport(Request $request)
    {
        //consolidated_earning
        if($request->report_type == 'account_statement' && $request->pdf) {
            return $this->generatePdfFilteredAccountStatement($request);
        }elseif ($request->report_type == 'account_statement' && $request->excel){
            return $this->generateExcelFilteredAccountStatement($request);
        }elseif ($request->report_type == 'loan_statement' && $request->pdf){
            return $this->generatePDFFilteredLoanStatement($request);
        }elseif ($request->report_type == 'loan_statement' && $request->excel){
            return $this->generateExcelFilteredLoanStatement($request);
        }elseif ($request->report_type == 'trans_statement' && $request->pdf){
            return $this->generatePDFFilteredTransactionStatement($request);
        }elseif ($request->report_type == 'trans_statement' && $request->excel) {
            return $this->generateExcelFilteredTransactionStatement($request);
        }

    }

    private function generatePdfFilteredAccountStatement(Request $request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));

        $savings = Saving::select('id', 'description', 'amount_saved', 'amount_withdrawn', 'balance', 'month')
            ->where('user_id', Auth::id())
            ->whereBetween('month',[$start_date,$end_date])
            ->orderByDesc('id')
            ->get();
        $total_savings = 0;$total_withdrawal = 0;
        $account_balance = 0;
        foreach ($savings as $saving){
            if($saving->description == 'Monthly Savings'){
                $total_savings = $total_savings + $saving->amount_saved;
            }elseif($saving->description == 'Savings Withdrawal'){
                $total_withdrawal = $total_withdrawal + $saving->amount_withdrawn;
            }
        }

        if (count($savings) > 0 ) {
            $pdf = PDF::loadView('dashboard/reports/user/filteredAccountStatement',compact('savings', 'start_date', 'end_date','total_withdrawal','total_savings'));
            \App\Helpers\LogActivity::logUserActivity(' User Downloaded Filtered PDF Account Statement');
            Toastr::success('Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $pdf->download('filteredAccountStatement.pdf');

        }else {
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

        }

    private function generateExcelFilteredAccountStatement(Request $request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));

        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Filtered Excel Account Statement');
        return (new ExcelFilteredAccountStatement($start_date, $end_date))->download('FilteredAccountStatement.xlsx');

    }

    private function generatePDFFilteredLoanStatement($request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));

        $loans = Loan::where([['user_id','=',Auth::id()], ['status','=','Approved']])
                       ->whereBetween('created_at',[$start_date.'%', $end_date.'%'])
                       ->get();
        $total_loan = 0;
        $total_interest_payable = 0;
        $total_payable = 0;
        foreach ($loans as $loan){
            $total_loan = $total_loan + $loan->loan_amount;
            $total_interest_payable = $total_interest_payable + $loan->total_interest_payable;
            $total_payable = $total_payable + $loan->total_amount_payable;
        }

        if (count($loans) > 0 ) {
            $pdf = PDF::loadView('dashboard/reports/user/pdfFilteredLoanStatement',
                                compact('loans', 'start_date', 'end_date','total_loan','total_interest_payable','total_payable'));
            Toastr::success('Loan Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            \App\Helpers\LogActivity::logUserActivity(' User Downloaded PDF Filtered Loan Account Statement');
            return $pdf->download(Auth::user()->ippis_no.'/Loan Statement.pdf');

        }else {
            Toastr::warning('No loan(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }

    private function generateExcelFilteredLoanStatement($request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));

        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Excel Filtered Loan Account Statement');
        return (new ExcelFilteredLoanStatement($start_date, $end_date))->download('FilteredLoanStatement.xlsx');

    }

    private function generatePDFFilteredTransactionStatement($request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$start_date, $end_date])
            ->orderByDesc('id')
            ->get();

        $total_transaction = 0;
        foreach ($transactions as $transaction){
            $total_transaction = $total_transaction + $transaction->transaction_amount;
        }

        if (count($transactions) > 0) {
            $pdf = PDF::loadView('dashboard/reports/user/pdfFilteredTransactionStatement',
                compact('transactions', 'start_date', 'end_date', 'total_transaction'));
            \App\Helpers\LogActivity::logUserActivity(' User Downloaded PDF Filtered Transaction Report');
            Toastr::success('Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $pdf->download('filteredTransactionStatement.pdf');

        } else {
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    private function generateExcelFilteredTransactionStatement($request)
    {
        $date_obj = strtr($request->date_range, '/', '-');
        $raw_start_date = substr($date_obj, 0, 10);
        $raw_end_date = substr($date_obj, 13, 23);
        $start_date = date("Y-m-d", strtotime($raw_start_date));
        $end_date = date("Y-m-d", strtotime($raw_end_date));
        \App\Helpers\LogActivity::logUserActivity(' User Downloaded Excel Filtered Transaction Report');
        return (new ExcelFilteredTransactionStatement($start_date, $end_date))->download('excelFilteredTransactionStatement.xlsx');

    }

    }
