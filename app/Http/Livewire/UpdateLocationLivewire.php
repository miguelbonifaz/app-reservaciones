<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class UpdateLocationLivewire extends ModalComponent
{
    public $locationId;

    public $form = [
        'name'
    ];

    public function mount($locationId)
    {
        $this->locationId = $locationId;

        $location = Location::find($locationId);

        $this->form['name'] = $location->name;
    }

    public function updateLocation()
    {
        $this->validate([
            'form.name' => 'required'
        ]);

        $location = Location::find($this->locationId);
        $location->update([
           'name' => $this->form['name']
        ]);

        session()->flash('flash_success', 'Se actualizó con éxito la localidad');

        return redirect()->to(route('locations.index'));
    }

    public function render()
    {
        return view('livewire.update-location-livewire');
    }
}
