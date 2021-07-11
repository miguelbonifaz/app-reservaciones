<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class EmptyList extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.ui.empty-list');
    }
}
