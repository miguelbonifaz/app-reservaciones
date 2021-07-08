<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Text extends Component
{
    public $label;
    public $placeholder;
    public $type;
    public $name;

    public function __construct($name, $placeholder = null, $label = false, $type = 'text')
    {
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->name = $name;
    }

    public function render()
    {
        return view('components.ui.text');
    }
}
