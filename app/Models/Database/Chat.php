<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'user_id',
        'chat_with',
    ];

    public $timestamps = false;

}