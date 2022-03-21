<?php

namespace App\Listeners;

use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserTableListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //update user's table
        User::where('email',$event->paymentDetails['data']['customer']['email'])->update([
            'membership_status' => 1,
        ]);
    }
}
