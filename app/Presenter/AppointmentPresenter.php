<?php

namespace App\Presenter;

use App\Models\Appointment;

class AppointmentPresenter
{
    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function date(): string
    {
        return $this->appointment->date->format('F j Y');
    }

    public function note(): ?string
    {
        return $this->appointment->note;
    }
}
