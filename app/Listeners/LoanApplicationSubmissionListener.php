<?php

namespace App\Listeners;

use App\Mail\AccountActivated;
use App\Mail\LoanApplicationNotifySecAndChair;
use App\Mail\LoanApplicationSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LoanApplicationSubmissionListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
           //notify the user
        Mail::to($event->loan_details['user_email'])->send((new LoanApplicationSubmitted($event->loan_details)));

        //notify all the admin
        foreach ($event->loan_details['admin_email'] as $admin_email){
            Mail::to($admin_email)->send((new LoanApplicationNotifySecAndChair($event->loan_details)));
        }
    }
}
