<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostPlaceOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderUid, $userId;
    /**
     * Create a new event instance.
     * @param $orderUid
     * @param $userId
     * @return void
     */
    public function __construct($orderUid, $userId)
    {
        $this->orderUid = $orderUid;
        $this->userId = $userId;
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
