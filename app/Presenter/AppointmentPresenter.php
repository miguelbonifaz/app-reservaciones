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
        $date = $this->appointment->date;

        return $date->format('d') . " de {$date->getTranslatedMonthName()} " . $date->format('Y');
    }

    public function startTime(): string
    {
        return $this->appointment->start_time->format('H:i A');
    }

    public function endTime(): string
    {
        return $this->appointment->end_time->format('H:i A');
    }

    public function note(): ?string
    {
        return $this->appointment->note;
    }
}
