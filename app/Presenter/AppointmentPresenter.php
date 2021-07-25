<?php

namespace App\Presenter;

use App\Models\Appointment;
use Carbon\Carbon;

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
    public function startTime(): string
    {
        $startTime = Carbon::createFromTimestamp($this->appointment->start_time);

        return $startTime->format('H:m');
    }
    public function endTime(): string
    {
        $endTime = Carbon::createFromTimestamp($this->appointment->end_time);
        return $endTime->format('H:m');
    }

    public function note(): ?string
    {
        return $this->appointment->note;
    }
}
