<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

class MyProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        $redirectUrl = request('redirectUrl');

        return view('me.edit', [
            'user' => $user,
            'redirectUrl' => $redirectUrl,
        ]);
    }

    public function update()
    {
        $user = auth()->user();

        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            Rule::unique('users', 'email')->ignoreModel($user),
            'password' => [
                'nullable',
                'min:8'
            ]
        ]);

        $user->update([
            'name' => request()->name,
            'email' => request()->email,
        ]);

        if (!empty(request()->password))
            $user->update(['password' => bcrypt(request()->password)]);

        if (request()->hasFile('avatar')) {
            $user->saveAvatar(request()->avatar);
        }

        return redirect()
            ->route('profile.edit', [$user, 'redirectUrl' => request('redirectUrl')])
            ->with('flash_success', 'Se actualizó con éxito su perfil.');
    }
}
