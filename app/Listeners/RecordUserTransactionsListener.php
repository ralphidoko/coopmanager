<?php

namespace App\Listeners;

use App\ChartOfAccount;
use App\Expense;
use App\GeneralLedger;
use App\Income;
use App\Journal;
use App\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecordUserTransactionsListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Transaction::create([
            'user_id' => $event->user_id,
            'user_email' => $event->paymentDetails['data']['customer']['email'],
            'transaction_type' => $event->transaction_type,
            'transaction_amount' => $event->coopFees,
            'transaction_action' => 'Credit',
            'transaction_date' => $event->newDate,
            'channel' => $event->paymentDetails['data']['channel'],
            'transaction_reference' => $event->paymentDetails['data']['reference']
        ]);

        //Post transaction into gl
        $revenueCount = Income::all()->count();
        $revenueCount = sprintf('REV/'.date('Y')."/%'.05d",$revenueCount+1);
        $revenueID = Journal::where('name','Customer Invoices')->first()->id;
        $charOfAccountID = ChartOfAccount::where('name','Revenue')->first()->id;
        $cumulativeBalance = GeneralLedger::orderBy('id','desc')->first();

        $_cumulativeBalance = ($cumulativeBalance != null) ?
        $cumulativeBalance->cumulative_balance +  $event->coopFees : $event->coopFees;

        GeneralLedger::create([
            'journal_id' => $revenueID,
            'coa_id' => $charOfAccountID,
            'vendor' => 'Nepza Cooperative',
            'reference' => $event->transaction_type,
            'move' => $revenueCount,
            'credit' => $event->coopFees,
            'cumulative_balance' => $_cumulativeBalance,
        ]);

    }


}
