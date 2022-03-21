<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipRenewalNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $paymentDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userName = User::where('email', $this->paymentDetails['data']['customer']['email'])->firstOrFail()->name;
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Membership Renewal Notification')
            ->view('dashboard.mail.membershipRenewalNotification',['userName'=>$userName]);
    }
}
