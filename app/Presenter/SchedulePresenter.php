<?php

namespace App\Presenter;

use App\Models\Schedule;

class SchedulePresenter
{
    public $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function dayOfWeek(): string
    {
        switch ($this->schedule->day) {
            case 0:
                return 'Domingo';
                break;
            case 1:
                return 'Lunes';
                break;
            case 2:
                return 'Martes';
                break;
            case 3:
                return 'Miercoles';
                break;
            case 4:
                return 'Jueves';
                break;
            case 5:
                return 'Viernes';
                break;
            case 6:
                return 'Sábado';
                break;
        }
    }
}
