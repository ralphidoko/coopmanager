<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuthorityToDeductPayMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $deduction_details;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($deduction_details)
    {
        //
        $this->deduction_details = $deduction_details;
    }

}
