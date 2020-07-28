<?php


namespace App\Models\Events;


use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UpdateChat implements ShouldBroadcastNow
{

    private $for;
    private $chat_ids;

    public function broadcastOn()
    {
        return new Channel('ChatUpdates');
    }

    public function broadcastWith()
    {
        return $this->message->toArray();
    }
    public function broadcastAs()
    {
        return 'ChatUpdate';
    }

}