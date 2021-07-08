<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Error extends Component
{
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.ui.error');
    }
}
