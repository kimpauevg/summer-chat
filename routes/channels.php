<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Player;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('PrivateChat.{id}.{with}', function ($user, $id, $with) {
    $current_user = Player::getId($user->id);
    return in_array($current_user, [$id, $with]);
});
