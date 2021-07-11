<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserPhotoController extends Controller
{
    public function __invoke()
    {
        $user = request()->user;
        
        $user = User::firstWhere('id', $user);        
        
        $avatar = $user->getFirstMedia('avatar');

        $avatar->delete();

        return redirect()
            ->route('users.edit',$user)
            ->with('flash_success', 'Se eliminó con éxito la foto.');
    }
}
