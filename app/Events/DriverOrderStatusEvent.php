<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DriverOrderStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderUid;
    public $title;
    public $notify_type;
    public $description;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($orderUid, $title, $notify_type, $description)
    {
        $this->orderUid = $orderUid;
        $this->title = $title;
        $this->notify_type = $notify_type;
        $this->description = $description;
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
