<?php

namespace App\Http\Livewire;

use App\Models\Location;
use LivewireUI\Modal\ModalComponent;

class CreateLocationLivewire extends ModalComponent
{
    public $form = [
        'name'
    ];

    public function createLocation()
    {
        $this->validate([
            'form.name' => 'required'
        ]);

        Location::create([
           'name' => $this->form['name']
        ]);

        session()->flash('flash_success', 'Se creó con éxito la localidad');

        return redirect()->to(route('locations.index'));
    }

    public function render()
    {
        return view('livewire.create-location-livewire');
    }
}
