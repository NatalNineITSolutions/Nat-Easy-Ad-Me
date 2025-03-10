<?php

namespace Modules\Chat\app\Events;
use Illuminate\Broadcasting\InteractsWithSockets;use Illuminate\Broadcasting\PrivateChannel;use Illuminate\Contracts\Broadcasting\ShouldBroadcast;use Illuminate\Foundation\Events\Dispatchable;use Illuminate\Queue\SerializesModels;
use Modules\Chat\app\Models\LiveChat;
use Modules\Chat\app\Models\LiveChatMessage;

class LivechatUserMessageEvent implements ShouldBroadcast
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
            new PrivateChannel('livechat-user-channel.' . $this->member_id . '.' . $this->user_id),
        ];
    }

    function broadcastAs(): string
    {
        return 'livechat-user-' . $this->user_id;
    }
}
