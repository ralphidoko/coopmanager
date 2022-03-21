<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecreaseSavingSubmission extends Mailable
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
        $this->deduction_details = $deduction_details;
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
            ->subject('Decrease Saving Notification')
            ->view('dashboard.mail.decreaseSavingSubmission',['deduction_details'=>$this->deduction_details]);
    }
}
