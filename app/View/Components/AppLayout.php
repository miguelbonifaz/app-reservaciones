<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $headerTitle;

    public function __construct($headerTitle)
    {
        $this->headerTitle = $headerTitle;
    }

    public function render()
    {
        return view('layouts.app');
    }
}
