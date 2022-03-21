<?php

namespace App\Listeners;

use App\Application;
use App\Income;
use App\Installment;
use App\Loan;
use App\Transaction;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class offSetLoanBalanceListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $date = $event->paymentData['data']['transaction_date'];
        $trans_date = date('Y-m-d', strtotime($date));
        $loan_bal_amount = ($event->paymentData['data']['amount']/100);
        $user_id = User::where('email',$event->paymentData['data']['customer']['email'])->first()->id;

        //determine the % of interest meant for cooperative income
        $loanObj = Loan::where('id',$event->paymentData['data']['metadata']['loan_id'])->firstOrFail();
        $income_percentage = ($loanObj->total_interest_payable/$loanObj->total_amount_payable) * 100;
        $coopIncome = $loan_bal_amount * ($income_percentage/100);

        //update installment table setting loan_status to paid
        Installment::where('loan_id',$event->paymentData['data']['metadata']['loan_id'])->update([
            'status' => 'Paid'
        ]);

        //update loan table
        Loan::where('id',$event->paymentData['data']['metadata']['loan_id'])->update([
            'status' => 'Settled'
        ]);

        //update income table
        $loanIncomeObj = Income::where('loan_id',$loanObj->id)->first();
        if($loanIncomeObj == null){
            Income::create([
                'loan_id' => $event->paymentData['data']['metadata']['loan_id'],
                'income_type' => 'Interest On Loan',
                'user_id' => $user_id,
                'income_realized' => $coopIncome,
            ]);
        }else{
            Income::where('loan_id',$event->paymentData['data']['metadata']['loan_id'])->update([
                'income_realized' => $loanIncomeObj->income_realized + $coopIncome,
            ]);
        }

        //delete loan application from application table
        Application::where('user_id',Auth::id())->delete();

        //move instalment to instalment achieve

        //call income distribution function

    }
}
