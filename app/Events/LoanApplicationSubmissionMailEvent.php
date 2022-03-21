<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanApplicationSubmissionMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $loan_details;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loan_details)
    {
        //
        $this->loan_details = $loan_details;
    }

}
