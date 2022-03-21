<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorityToDeductPaySubmitted extends Mailable
{
    use Queueable, SerializesModels;
    public $deduction_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($deduction_details)
    {
        //
        return $this->deduction_details = $deduction_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // dd($deduction_details);
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Notification of Authority To Deduct Pay')
            ->view('dashboard.mail.authorityToDeductPaySubmission',['deduction_details'=>$this->deduction_details]);
    }


}
