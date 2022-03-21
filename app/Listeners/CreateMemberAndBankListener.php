<?php

namespace App\Listeners;

use App\Bank;
use App\Member;

class CreateMemberAndBankListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //creating member's profile on the fly
        Member::create([
            'first_name' => $event->usersDetails->name,
            'email' => $event->usersDetails->email,
            'user_id' =>$event->usersDetails->id,
        ]);

        //creating banking details profile on the fly
        Bank::create([
             'account_name' => $event->usersDetails->name,
             'user_id' =>$event->usersDetails->id,
         ]);
    }

}
