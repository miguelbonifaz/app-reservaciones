<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $placeholder;
    public $type;
    public $name;

    public function __construct($name, $placeholder = null, $label = false)
    {
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->name = $name;
    }

    public function render()
    {
        return view('components.ui.select');
    }
}
