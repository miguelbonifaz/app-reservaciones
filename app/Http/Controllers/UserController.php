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

        return view('users.create',[
            'user' => $user
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

    public function edit()
    {
        $user = request()->user;

        $user = User::firstWhere('id',$user);
        
        return view('users.edit',[
            'user' => $user
        ]);
    }

    public function update()
    {
        $user = request()->user;

        $user = User::firstWhere('id',$user);

        request()->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update([
            'name' => request()->name,                
            'email' => request()->email,                   
            'password' => bcrypt(request()->password)            
        ]);
        
        if (request()->hasFile('avatar')) {         
            $user->saveAvatar(request()->avatar);
        }     
        
        return redirect()
            ->route('users.index')
            ->with('flash_success', 'Se actualizó con éxito el usuario.');
    }

    public function destroy()
    {
        
        $user = request()->user;

        $user = User::firstWhere('id',$user);

        $avatar = $user->getFirstMedia('avatar');

        if($avatar){
            $avatar->delete();
        }    
        
        $user->delete();        
        
        return redirect()
            ->route('users.index')
            ->with('flash_success', 'Se eliminó con éxito el usuario.');
    }
    
}
