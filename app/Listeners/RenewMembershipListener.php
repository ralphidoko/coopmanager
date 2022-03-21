<?php

namespace App\Listeners;

use App\Income;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class RenewMembershipListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       User::onlyTrashed()->where([['email',$event->paymentDetails['data']['customer']['email']],['member_id',$event->paymentDetails['data']['metadata'][3]]])
           ->update([
           'is_admin' => 0,
           'user_role' => NULL,
           'deleted_at' => NULL,
           'membership_renewal_status' => 'Request Submitted',
        ]);
        \App\Helpers\LogActivity::logUserActivity(' User Renewed Membership',$event->user_id);
        //update income table
        Income::create([
            'income_realized' => $event->coopFees,
            'income_type' => $event->transaction_type,
            'user_id' => $event->user_id,
        ]);
    }
}
