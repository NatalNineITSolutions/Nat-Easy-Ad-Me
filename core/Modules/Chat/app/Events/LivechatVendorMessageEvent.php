<?php

namespace Modules\Chat\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LivechatVendorMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $user_id, $member_id;
    public $message, $livechat, $messageBlade;

    public function __construct(string $messageBlade,$message, $livechat,$user_id,$member_id)
    {
        $this->messageBlade = $messageBlade;
        $this->message = $message;
        $this->livechat = $livechat;
        $this->member_id = $member_id;
        $this->user_id = $user_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('livechat-member-channel.' . $this->user_id . '.' . $this->member_id),
        ];
    }

    function broadcastAs(): string
    {
        return 'livechat-member-'.$this->member_id;
    }
}
