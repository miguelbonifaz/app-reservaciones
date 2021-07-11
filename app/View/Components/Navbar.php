<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Navbar extends Component
{
    public function __construct()
    {

    }

    public function menu(): Collection
    {
        return collect([
            [
                'title' => 'Calendario',
                'route' => route('calendar.index'),
                'isActive' => request()->routeIs('calendar.index')
            ],
            [
                'title' => 'Empleados',
                'route' => route('employees.index'),
                'isActive' => request()->routeIs('employees.index')
            ],
            [
                'title' => 'Usuarios',
                'route' => route('users.index'),
                'isActive' => request()->routeIs('users.index')
            ],
        ]);
    }

    public function render()
    {
        return view('components.navbar');
    }
}
