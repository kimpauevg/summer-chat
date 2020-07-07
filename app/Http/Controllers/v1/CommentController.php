<?php


namespace App\Http\Controllers\v1;


use App\Models\Chat;
use App\Models\Database\Message;
use App\Models\Utils\Response;
use Illuminate\Http\Request;

class CommentController extends V1Controller
{

    public function store($another_player_id, Request $request)
    {
        if ((int)$another_player_id <= 0) {
            abort(404);
        }
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);
        Chat::sendNewMessage($request->post('comment'), $another_player_id);
        return Response::ok();
    }
}