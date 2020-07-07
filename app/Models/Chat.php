<?php


namespace App\Models;


use App\Models\Database\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Database\Chat as DbChat;

class Chat
{

    public static function getMessages($chat_with, $params = [])
    {
        $id = self::tryGetChatId($chat_with);
        $messages = DB::select('
        SELECT 
            message,
            chat_messages.created_at,
            chat_messages.updated_at,
            players.nickname,
            players.id as player_id
        FROM chat_messages
        LEFT JOIN players on players.id = chat_messages.user_id
        WHERE chat_id = :id
        ORDER BY created_at DESC
        LIMIT 50
        ', [
            'id' => $id
        ]);

        $messages = array_map(function ($message) {
            $message->message = str_replace(PHP_EOL.PHP_EOL, PHP_EOL, $message->message);
            return $message;
        }, $messages);
        return $messages;
    }

    public static function getChatsList($params = [])
    {
        $amount_on_page = 5;
        if (isset($params['amount_on_page'])) {
            $amount_on_page = $params['amount_on_page'];
        }
        $page = 0;
        if (isset($params['page'])) {
            $page = $params['page'];
        }
        $player_id = Player::getId();
        $offset = $page * $amount_on_page;
        $found_chats = DB::select('
        SELECT 
            chats.id,
            message,
            chat_messages.updated_at,
            players.nickname
        FROM chats
        LEFT JOIN chat_messages ON chat_messages.id = (SELECT MAX(id) from chat_messages WHERE chat_id = chats.id)
        LEFT JOIN players ON players.user_id = :uid1
        WHERE chats.user_id = :uid2 OR chats.chat_with = :uid3
        LIMIT :on_page
        OFFSET :offset
        ', [
            'on_page' => $amount_on_page,
            'offset' => $offset,
            'uid1' => $player_id,
            'uid2' => $player_id,
            'uid3' => $player_id,
        ]);
        return $found_chats;
    }

    public static function sendNewMessage($message, $chat_with)
    {
        $chat_id = self::tryGetChatId($chat_with);
        $player_id = Player::getId();
        if(!$chat_id) {
            DbChat::create([
                'user_id' => $player_id,
                'chat_with' => $chat_with
            ]);
            $chat_id = self::tryGetChatId($chat_with);
        }
        Message::create([
            'message' => $message,
            'chat_id' => $chat_id,
            'user_id' => $player_id,
        ]);
    }

    private static function tryGetChatId($chat_with)
    {
        $current_user_id = Player::getId();
        $chat_id = DB::selectOne('
        SELECT id
        FROM chats
        WHERE (user_id = :uid AND chat_with = :uid1)
           OR (user_id = :uid2 AND chat_with = :uid3)
        LIMIT 1
        ', [
            'uid' => $chat_with,
            'uid1' => $current_user_id,
            'uid2' => $current_user_id,
            'uid3' => $chat_with
        ]);
        if ($chat_id) {
            return $chat_id->id;
        }
        return false;

    }
}