<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $label;
    public $name;
    public $value;

    public function __construct($name, $value, $label = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.ui.checkbox');
    }
}
