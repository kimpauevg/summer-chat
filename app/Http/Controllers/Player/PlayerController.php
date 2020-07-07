<?php

namespace App\Http\Controllers\Player;

use App\Models\Player;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\Controller;
use \App\Models\Utils\Response;

class  PlayerController extends Controller
{

    public function index()
    {

        var_dump(Player::getId());
    }



    /**
     * @param array $data
     * @return array
     */
    protected function store(Request $request)
    {
        $request->validate([
            'nickname' => ['required', 'unique:players', 'string', 'max:50'],
        ]);
        $data = $request->post();
        $result = \App\Models\Player::create([
            'nickname' => $data['nickname'],
            'user_id' => Auth::id(),
        ]);
        if (!$result) {
            return Response::error($result);
        }
        return Response::ok();
    }


}