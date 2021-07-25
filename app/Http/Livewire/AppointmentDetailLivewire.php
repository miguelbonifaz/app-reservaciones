<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use LivewireUI\Modal\ModalComponent;

class AppointmentDetailLivewire extends ModalComponent
{
    public $appointmentId;

    public function mount($appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    public function getAppointmentProperty()
    {
        return Appointment::find($this->appointmentId);
    }

    public function render()
    {
        return view('livewire.appointment-detail-livewire');
    }
}
