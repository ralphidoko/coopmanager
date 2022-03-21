<?php

namespace App\Listeners;

use App\Application;
use App\Loan;
use App\Transaction;
use App\User;
use http\Env\Request;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class CreateLoanApplicationBoilerRecordListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    //get user id from transaction table
//    private function AuthenticatedUser(){
//        return Transaction::latest()->first()->user_id;
//    }

    public function handle($event)
    {
        //create application boiler record
        $user_id = User::where('email',$event->paymentDetails['data']['customer']['email'])->first()->id;

        Application::updateOrCreate(
            ['user_id' => $user_id],
            ['status' => 'Payment Confirmed']
        );
    }
}
