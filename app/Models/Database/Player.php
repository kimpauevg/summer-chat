<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'user_id',
    ];
    public static function getId()
    {
        $id_from_session = request()->session()->get('player_id');
        if ($id_from_session) {
            return $id_from_session;
        }
        $user_id = Auth::id();
        if (!$user_id) {
            return null;
        }
        $id_from_db = DB::selectOne('SELECT id FROM players where user_id = ? LIMIT 1',[$user_id])->id;
        if ($id_from_db) {
            request()->session()->put('player_id');
        }
        return $id_from_db;
    }
}