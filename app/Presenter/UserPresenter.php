<?php

namespace App\Presenter;

use App\Models\User;

class UserPresenter
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function name()
    {
        return $this->user->name;
    }
    
    public function email()
    {
        return $this->user->email;
    }
}
