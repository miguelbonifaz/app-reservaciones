<?php

namespace App\Http\Controllers;

class UserPhotoController extends Controller
{
    public function __invoke()
    {
        $user = request()->user;

        $avatar = $user->getFirstMedia('avatar');

        $avatar->delete();

        return redirect()
            ->route('users.edit',$user)
            ->with('flash_success', 'Se eliminó con éxito la foto.');
    }
}
