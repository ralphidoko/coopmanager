<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistrationNotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $registeredUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registeredUser)
    {
        //
        return $this->registeredUser = $registeredUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Membership Registration Notification')
            ->view('dashboard.mail.newRegistrationNotifyAdmin',['registeredUser'=>$this->registeredUser]);
    }
}
