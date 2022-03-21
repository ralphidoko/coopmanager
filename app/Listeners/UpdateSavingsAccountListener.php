<?php

namespace App\Listeners;

use App\Saving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UpdateSavingsAccountListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Saving::create([
            'user_id' => $event->user_id,
            'description' => $event->transaction_type,
            'ippis_no' => Auth::user()->ippis_no,
            'amount_saved' => ($event->paymentDetails['data']['amount'] / 100),
            'month' => $event->newDate,
        ]);
    }
}
