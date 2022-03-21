<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateIncomeAndAuthorityToDeductPayEvent
{
    public $paymentDetails,$user_id,$coopFees;
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($paymentDetails,$user_id,$coopFees)
    {
        $this->paymentDetails  = $paymentDetails;
        $this->user_id  = $user_id;
        $this->coopFees = $coopFees;
    }


}
