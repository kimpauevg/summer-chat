<?php


namespace App\Models;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profile
{
    public static function getProfileInfo($id = null)
    {
        if ($id === null) {
            $id = Player::getId();
        }

        $data = (array) DB::selectOne('
        SELECT 
            user_id,
            players.id as player_id,
            users.name,
            nickname,
            players.created_at
        FROM users
        JOIN players on users.id = user_id
        WHERE players.id = ?
        LIMIT 1
        ', [$id]);
        return $data;
    }
}