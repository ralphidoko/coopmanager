<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateIncomeAndOtherDetailsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $paymentDetails,$user_id,$coopFees,$transaction_type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($paymentDetails,$user_id,$coopFees,$transaction_type)
    {
        //
        $this->paymentDetails = $paymentDetails;
        $this->user_id = $user_id;
        $this->coopFees = $coopFees;
        $this->transaction_type = $transaction_type;
    }


}
