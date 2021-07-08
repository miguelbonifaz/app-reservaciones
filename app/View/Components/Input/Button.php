<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Button extends Component
{
    public $theme;

    public function __construct($theme = '')
    {
        if ($theme == 'white') {
            $this->theme = 'inline-flex items-center py-2 px-4 border font-medium border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
        } else {
            $this->theme = 'inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-gray-900 leading-4 rounded-md border border-transparent shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500';
        }
    }

    public function render()
    {
        return view('components.ui.button');
    }
}
