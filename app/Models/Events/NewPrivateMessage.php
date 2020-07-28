<?php

namespace App\Models\Events;
use App\Models\Chat;
use App\Models\Database\Message;
use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPrivateMessage implements ShouldBroadcastNow
{
    /**
     * @var Message $message
     */
    public $message;
    private $chat_with;

    public function __construct($chat_with, Message $message)
    {
        $this->message = $message;
        $this->chat_with = $chat_with;
    }

    public function broadcastOn()
    {
        return new Channel('ChatUpdate' . $this->chat_with);
    }

    public function broadcastWith()
    {
        return $this->message->toArray();
    }
    public function broadcastAs()
    {
        return 'NewPrivateMessage';
    }

}