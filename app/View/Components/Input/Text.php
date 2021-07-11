<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Text extends Component
{
    public $label;
    public $placeholder;
    public $type;
    public $name;
    public $value;

    public function __construct($name, $label = false, $type = 'text', $value = null, $placeholder = null)
    {
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.ui.text');
    }
}
