<?php

namespace App\Http\Controllers;

use App\Application;
use App\AuthorityToDeductPay;
use App\ChartOfAccount;
use App\GeneralLedger;
use App\Income;
use App\Installment;
use App\Journal;
use App\Loan;
use App\LoanIncome;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoanInstalmentSettlementController extends Controller
{

    public function showLoanInstalments()
    {
        $loans = Loan::with('installments')->where('status','Approved')->paginate(10);
        return view('dashboard.admin.loanInstallmentsPayment',compact('loans'));
    }

    public function settleLoanInstallments(Request $request)
    {
        //getting and de-duplicating loan id for sundry use
        $arrayOfLoanIDs = [];
        foreach ($request->installmentsIDs as $nstallmentsID) {
            $loanID = DB::table('installments')->select('loan_id')->where('unique_id',$nstallmentsID)->first();
            array_push($arrayOfLoanIDs,$loanID->loan_id);
        }
        $arrayOfLoanID = array_unique($arrayOfLoanIDs);

        //update installment table
        $settleInstallments = Installment::whereIn('unique_id',$request->installmentsIDs)->update([
            'status' => 'Paid'
        ]);

        foreach($request->installmentsIDs as $nstallmentsID){
            $installmentDetails = DB::table('installments')->select('loan_id', 'monthly_installment','current_balance','payment_date')->where('unique_id',$nstallmentsID)->first();
            $loanID = $installmentDetails->loan_id;
            $currentInstalment = $installmentDetails->monthly_installment;
            $paymentDate = $installmentDetails->payment_date;
            (new AdminCalculationController)->incomeOnLoanInstallment($loanID,$currentInstalment);
            (new AdminCalculationController)->calculateRecoveredLoan($loanID,$currentInstalment);
        }

        $countOfLoanIDs = array_count_values($arrayOfLoanIDs);

         foreach($countOfLoanIDs as $key => $value){
             $loanObject = Loan::where('id',$key)->first();
             $_currentLoanBalance = Installment::where([['loan_id', $key],['status','Unpaid']])->sum('monthly_installment');
             $_currentInstalment = Installment::where('loan_id',$key)->first()->monthly_installment;
             $userEmail = $loanObject->users->email;
             $userName = $loanObject->users->name;
             if($value > 1){
                 $_currentInstalment = $_currentInstalment * $value;
                 $installmentDetails = [
                     'userName' =>$userName,
                     'email' => $userEmail,
                     'currentLoanBalance' =>$_currentLoanBalance,
                     'currentInstalment' => $_currentInstalment,
                     'paymentDate' => $paymentDate,
                 ];
                 (new MailController)->installmentPaymentNotification((array)$installmentDetails);
             }else{
                 $installmentDetails = [
                     'userName' =>$userName,
                     'email' => $userEmail,
                     'currentLoanBalance' =>$_currentLoanBalance,
                     'currentInstalment' => $_currentInstalment,
                     'paymentDate' => $paymentDate,
                 ];
                 (new MailController)->installmentPaymentNotification((array)$installmentDetails);
             }

         }

        foreach($arrayOfLoanID as $settledLoan){
            $unpaidInstallments = DB::table('installments')->where([['loan_id','=',$settledLoan],['status','=','Unpaid']])->count();
            if($unpaidInstallments == 0):
                Loan::where('id',$settledLoan)->update(['status' => 'Settled',]);
                $incomeRealized = Income::where('loan_id',$settledLoan)->first()->income_realized;

                //Post transaction into gl
                $revenueCount = Income::all()->count();
                $revenueCount = sprintf('REV/'.date('Y')."/%'.05d",$revenueCount+1);
                $revenueID = Journal::where('name','Customer Invoices')->first()->id;
                $charOfAccountID = ChartOfAccount::where('name','Revenue')->first()->id;
                $cumulativeBalance = GeneralLedger::orderBy('id','desc')->first();

                $_cumulativeBalance =  ($cumulativeBalance != null) ?
                    $cumulativeBalance->cumulative_balance +  $incomeRealized :
                    $incomeRealized;

                GeneralLedger::create([
                    'journal_id' => $revenueID,
                    'coa_id' => $charOfAccountID,
                    'vendor' => 'Nepza Cooperative',
                    'reference' => 'Interest On Loan',
                    'move' => $revenueCount,
                    'credit' => $incomeRealized,
                    'cumulative_balance' => $_cumulativeBalance,
                ]);

            endif;
        }

       if($settleInstallments){
            $data = ['success' => true, 'message'=> "Selected installment(s) successfully settled!"];
            return response()->json($data);
        }


    }




}
