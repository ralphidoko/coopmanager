<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class membershipApprovalNotifyMember extends Mailable
{
    use Queueable, SerializesModels;
    public $applicationDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicationDetails)
    {
        //
        return $this->applicationDetails = $applicationDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Membership Approval Notification')
            ->view('dashboard.mail.membershipApprovalNotifyMember',['applicationDetails'=>$this->applicationDetails]);
    }
}
