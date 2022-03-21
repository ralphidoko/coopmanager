<?php

namespace App\Listeners;

use App\Application;
use App\AuthorityToDeductPay;
use App\Income;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UpdateIncomeAndAuthorityToDeductPayListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //update income table
        Income::create([
            'income_realized' => $event->coopFees,
            'income_type' => $event->transaction_type,
            'user_id' => $event->user_id,
        ]);

        AuthorityToDeductPay::create([
            'user_id' => $event->user_id,
        ]);
    }
}
