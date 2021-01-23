<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DistributorOrderPaymentReceivedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var $orderUid
     */
    public $orderUid;
    /**
     * Create a new event instance.
     * @param $orderUid
     * @return void
     */
    public function __construct($orderUid)
    {
        $this->orderUid = $orderUid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
