<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->get();                                    
        
        return view ('users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $user = new User();

        return view('users.create')
            ->with([
                'user' => $user,
            ]);
    }

    public function store()
    {                        
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => request()->name,                
            'email' => request()->email,                   
            'password' => bcrypt(request()->password)            
        ]);
        
        if (request()->hasFile('avatar')) {         
            $user->saveAvatar(request()->avatar);
        }     
        
        return redirect()
            ->route('users.index')
            ->with('flash_success', 'Se creó con éxito el usuario.');
    }
}
