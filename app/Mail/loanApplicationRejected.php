<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class loanApplicationRejected extends Mailable
{
    use Queueable, SerializesModels;
    public $rejection_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rejection_details)
    {
        //
        $this->rejection_details = $rejection_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($rejection_details);
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Loan Application Rejection Notification')
            ->view('dashboard.mail.loanApplicationRejected',['rejection_details'=>$this->rejection_details]);
    }
}
