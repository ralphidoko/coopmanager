<?php

namespace App\Listeners;

use App\Mail\AuthorityToDeductPayNotifyExcos;
use App\Mail\AuthorityToDeductPaySubmitted;
use Illuminate\Support\Facades\Mail;

class AuthorityToDeductPayMailListener
{
    public $deduction_details;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //notify the applicant
        Mail::to($event->deduction_details['user_email'])->send((new AuthorityToDeductPaySubmitted($event->deduction_details)));

        //notify all the admin
        foreach ($event->deduction_details['admin_email'] as $admin_email){
            Mail::to($admin_email)->send((new AuthorityToDeductPayNotifyExcos($event->deduction_details)));
        }
    }

}
