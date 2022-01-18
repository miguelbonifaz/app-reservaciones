<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $headerTitle;
    public $maxWidth;

    public function __construct($headerTitle, $maxWidth = 'max-w-7xl')
    {
        $this->headerTitle = $headerTitle;
        $this->maxWidth = $maxWidth;
    }

    public function render()
    {
        return view('layouts.app');
    }
}
