<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WebsiteLayout extends Component
{
    public function __construct()
    {

    }

    public function render()
    {
        return view('website.layout.app');
    }
}
