<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyStoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var $storeId
     * @var $orderUid
     * @var $type
     * @var $title
     * @var $description
     */
    public $storeId, $orderUid, $type, $title, $description;

    /**
     * Create a new event instance.
     * @param $storeId
     * @param $orderUid
     * @param $type
     * @param $title
     * @param (optional) $description
     * @return void
     */
    public function __construct($storeId, $orderUid, $type, $title, $description = null)
    {
        $this->storeId     = $storeId;
        $this->orderUid    = $orderUid;
        $this->type        = $type;
        $this->title       = $title;
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
