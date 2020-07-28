<?php


namespace App\Models;


use App\Models\Database\Message;
use App\Models\Events\NewPrivateMessage;
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
            $message->message = str_replace(PHP_EOL . PHP_EOL, PHP_EOL, $message->message);
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
        $query = '
        SELECT 
            chats.id,
            message,
            chat_messages.updated_at,
            (CASE 
                WHEN :uid = chats.user_id 
                    THEN chats.chat_with 
                ELSE chats.user_id 
            END) as companion_id,
            players.nickname
        FROM chats
        LEFT JOIN chat_messages ON chat_messages.id = (SELECT MAX(id) from chat_messages WHERE chat_id = chats.id)
        LEFT JOIN players 
            ON CASE 
                WHEN :uid = chats.user_id 
                    THEN chats.chat_with 
                ELSE chats.user_id 
            END =  players.id 
        WHERE chats.user_id = :uid OR chats.chat_with = :uid
        LIMIT :on_page
        OFFSET :offset
        ';
        /**
         * Security problem possible
         */
        $query = str_replace(':uid', $player_id, $query);

        $found_chats = DB::select($query, [
            'on_page' => $amount_on_page,
            'offset' => $offset,
        ]);
        return $found_chats;
    }

    public static function sendNewMessage($message, $chat_with)
    {
        $chat_id = self::tryGetChatId($chat_with);
        $player_id = Player::getId();
        if (!$chat_id) {
            DbChat::create([
                'user_id' => $player_id,
                'chat_with' => $chat_with
            ]);
            $chat_id = self::tryGetChatId($chat_with);
        }
        $message = Message::create([
            'message' => $message,
            'chat_id' => $chat_id,
            'user_id' => $player_id,
        ]);
        broadcast(new NewPrivateMessage($chat_with, $message));

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

    public static function getChatKey($with)
    {
        $player_id = Player::getId();
        if ($player_id > $with) {
            $id_array = [
                $with,
                $player_id
            ];
        } else {
            $id_array = [
                $player_id,
                $with
            ];
        }
        return sprintf('PrivateInfo.%s.%s', $id_array[0], $id_array[1]);
    }
}