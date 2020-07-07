<?php

namespace App\Http\Controllers\v1;

use App\Models\Profile;

class ProfileController extends V1Controller
{
    public function index()
    {
        $profile = Profile::getProfileInfo();

        return view('profile.profile', ['profile' => $profile]);
    }

    public function update()
    {

    }
    public function show($id)
    {
        $profile = Profile::getProfileInfo($id);

        if (empty($profile)) {
            abort(404);
        }
        return view('profile.profile', ['profile' => $profile, 'id' => $id]);
    }


}