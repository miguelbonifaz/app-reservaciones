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

    public function date()
    {
        return $this->appointment->date;
    }

    public function note()
    {
        return $this->appointment->note;
    }
}
