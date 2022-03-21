<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstallmentPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $installmentDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($installmentDetails)
    {
       $this->installmentDetails = $installmentDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Installment Payment Notification')
            ->view('dashboard.mail.InstallmentPaymentNotification', ['installmentDetails'=>$this->installmentDetails]);
    }
}
