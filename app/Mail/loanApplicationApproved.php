<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class loanApplicationApproved extends Mailable
{
    use Queueable, SerializesModels;
    public $approval_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval_details)
    {
        //
        $this->approval_details = $approval_details;
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
            ->subject('Loan Application Approval Notification')
            ->view('dashboard.mail.loanApplicationApproved',['approval_details'=>$this->approval_details]);
    }
}
