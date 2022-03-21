<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class authorityToPayApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $deduct_pay_approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($deduct_pay_approval)
    {
        //
        $this->deduct_pay_approval = $deduct_pay_approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nepzacoop@gmail.com','Nepza Cooperative')
            ->subject('Authority To Deduct Pay Approval')
            ->view('dashboard.mail.authorityToDeductPayApproval',['deduct_pay_approval'=>$this->deduct_pay_approval]);
    }
}
