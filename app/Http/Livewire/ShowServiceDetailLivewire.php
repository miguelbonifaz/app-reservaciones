<?php

namespace App\Http\Livewire;

use App\Models\Service;
use LivewireUI\Modal\ModalComponent;

class ShowServiceDetailLivewire extends ModalComponent
{
    public $serviceId;

    public function mount($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    public function getServiceProperty()
    {
        return Service::find($this->serviceId);
    }

    public function render()
    {
        return view('livewire.show-service-detail-livewire');
    }
}
