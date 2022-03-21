<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivated extends Mailable
{
    use Queueable, SerializesModels;
    public $emailContents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailContents)
    {
        //
        return $this->emailContents = $emailContents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
                     ->subject('Successful Account Activation')
                     ->view('dashboard.mail.accountActivated',['email_data'=>$this->emailContents]);

    }
}
