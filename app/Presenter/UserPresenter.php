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

    public function avatarUrl()
    {
        return optional($this->user->avatar())->getFullUrl() ?? "https://ui-avatars.com/api/?name={$this->user->name}";
    }

}
