<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LPDebitEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId, $reason, $remark, $orderUid;

    /**
     * Create a new event instance.
     * @param $userId
     * @param $reason
     * @param $remark
     * @param $orderUid
     * @return void
     */
    public function __construct($userId, $reason, $remark, $orderUid)
    {
        $this->userId   = $userId;
        $this->reason   = $reason;
        $this->remark   = $remark;
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
