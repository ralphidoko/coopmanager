<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class membershipRejectionNotifyMember extends Mailable
{
    use Queueable, SerializesModels;
    public $rejectionDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rejectionDetails)
    {
        //
        return $this->rejectionDetails = $rejectionDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Membership Application Rejection Notification')
            ->view('dashboard.mail.membershipRejectionNotifyMember',['applicationDetails'=>$this->rejectionDetails]);
    }
}
