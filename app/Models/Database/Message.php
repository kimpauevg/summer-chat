<?php


namespace App\Models\Database;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = [
        'message',
        'chat_id',
        'user_id'
    ];

}