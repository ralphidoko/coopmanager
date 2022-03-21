<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;
    public $loan_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($loan_details)
    {
        //
        return $this->loan_details = $loan_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Loan Application Submission')
            ->view('dashboard.mail.loanApplicationSubmission',['loan_details'=>$this->loan_details]);
    }


}
