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
                'isActive' => request()->routeIs('calendar.*')
            ],
            [
                'title' => 'Empleados',
                'route' => route('employees.index'),
                'isActive' => request()->routeIs('employees.*')
            ],
            [
                'title' => 'Servicios',
                'route' => route('services.index'),
                'isActive' => request()->routeIs('services.*')
            ],
            [
                'title' => 'Clientes',
                'route' => route('customers.index'),
                'isActive' => request()->routeIs('customers.*')
            ],
            [
                'title' => 'Localidades',
                'route' => route('locations.index'),
                'isActive' => request()->routeIs('locations.*'),
            ],
            [
                'title' => 'Usuarios',
                'route' => route('users.index'),
                'isActive' => request()->routeIs('users.*')
            ],
        ]);
    }

    public function render()
    {
        return view('components.navbar');
    }
}
