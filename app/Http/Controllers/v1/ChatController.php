<?php


namespace App\Http\Controllers\v1;


use App\Models\Chat;
use App\Models\Player;
use App\Models\Profile;
use Illuminate\Http\Request;

class ChatController extends V1Controller
{

    public function index()
    {
        $chats = Chat::getChatsList();
        return view('chat.list', [
            'chats' => $chats
        ]);
    }

    public function show($player_id)
    {
        $profile_info = Profile::getProfileInfo($player_id);
        if (empty($profile_info)) {
            abort(404);
        }
        $messages = Chat::getMessages($player_id);
        $key = 'ChatUpdate' . Player::getId();

        return view('chat.chat', [
            'profile' => $profile_info,
            'messages' => $messages,
            'another_player_id' => $player_id,
            'key' => $key
        ]);
    }
}