<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuildAmortizationSchedule
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loanId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loanId)
    {
        $this->loanId = $loanId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('amortization-schedule');
    }
}
