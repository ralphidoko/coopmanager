<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RenewMembershipEvent
{
    public $paymentDetails,$transaction_type,$newDate,$coopFees,$user_id;
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id,$transaction_type,$coopFees,$paymentDetails)
    {
        $this->user_id = $user_id;
        $this->transaction_type = $transaction_type;
        $this->coopFees = $coopFees;
        $this->paymentDetails = $paymentDetails;
    }

}
