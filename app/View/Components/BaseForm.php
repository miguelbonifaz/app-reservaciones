<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BaseForm extends Component
{
    public $route;
    public $footer;

    public function __construct($route)
    {
        $this->footer = null;
        $this->route = $route;
    }

    public function render()
    {
        return view('components.ui.base-form');
    }
}
