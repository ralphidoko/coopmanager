<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SavingWithdrawalNotifyExcos extends Mailable
{
    use Queueable, SerializesModels;
    public $withdrawal_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdrawal_details)
    {
        //
        return $this->withdrawal_details = $withdrawal_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Savings Withdrawal Request Submission')
            ->view('dashboard.mail.savingWithdrawalNotifyExcos',['withdrawal_details'=>$this->withdrawal_details]);
    }

}
