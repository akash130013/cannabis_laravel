<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userId, $userType, $orderUid, $title, $description, $type;

    /**
     * Create a new event instance.
     * @param $userId
     * @param $userType
     * @param $orderUid
     * @param $title
     * @param $description
     * @param $type
     * @return void
     */
    public function __construct($userId, $userType, $orderUid, $title, $description, $type)
    {
        $this->userId      = $userId;
        $this->userType    = $userType;
        $this->orderUid    = $orderUid;
        $this->title       = $title;
        $this->description = $description;
        $this->type        = $type;
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
