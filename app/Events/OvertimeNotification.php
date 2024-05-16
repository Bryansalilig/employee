<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OvertimeNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notif_Id;
    public $employee;
    public $reason;
    public $message;
    public $url;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notif_Id, $message, $reason, $url, $employee)
    {
        $this->notif_Id = $notif_Id;
        $this->message = $message;
        $this->reason = $reason;
        $this->url = $url;
        $this->employee = $employee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('overtime-channel');
    }

    public function broadcastAs()
    {
        return 'overtime-event';
    }
}
