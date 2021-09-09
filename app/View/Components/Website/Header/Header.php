<?php

namespace App\View\Components\Website\Header;

use Illuminate\View\Component;

class Header extends Component
{
    public $withBackground;

    public function __construct($withBackground = true)
    {
        $this->withBackground = $withBackground;
    }

    public function render()
    {
        return view('components.website.header.header');
    }
}
