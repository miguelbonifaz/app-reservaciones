<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Asantibanez\LivewireResourceTimeGrid\LivewireResourceTimeGrid;
use Carbon\Carbon;

class WeeklyCalendarLivewire extends LivewireResourceTimeGrid
{
    public $currentDay;

    protected $casts = [
        'currentDay' => 'date',
        'date' => 'date',
    ];

    public function afterMount($extras)
    {
        $this->currentDay = today();
    }

    public function resources()
    {
        $today = $this->currentDay;

        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY);

        return collect([
            $startOfWeek->clone()->addDays(0),
            $startOfWeek->clone()->addDays(1),
            $startOfWeek->clone()->addDays(2),
            $startOfWeek->clone()->addDays(3),
            $startOfWeek->clone()->addDays(4),
            $startOfWeek->clone()->addDays(5),
        ])->map(function (Carbon $date) {
            return [
                'id' => $date->format('Y-m-d'),
                'title' => $date->format('l d'),
            ];
        });
    }

    public function events()
    {
        $today = $this->currentDay;

        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY);

        $endOfWeek = $today->copy()->endOfWeek(Carbon::SATURDAY);

        return Appointment::whereDate('date', '<=', $endOfWeek)
            ->whereDate('date', '>=', $startOfWeek)
            ->get()
            ->map(function (Appointment $appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->customer->present()->name(),
                    /* 'employee' => $appointment->employee->present()->name(), */
                    /* 'date' => $appointment->present()->date(), */
                    'starts_at' => Carbon::createFromTimestamp($appointment->start_time),
                    'ends_at' => Carbon::createFromTimestamp($appointment->end_time),
                    /* 'note' => $appointment->present()->note(), */
                    'resource_id' => $appointment->date->format('Y-m-d'),
                ];
            });
    }

    public function backToCurrentWeek()
    {
        $this->currentDay = Carbon::today();
    }

    public function goToPreviousWeek()
    {
        $this->currentDay = $this->currentDay->subDays(7);
    }

    public function goToNextWeek()
    {
        $this->currentDay = $this->currentDay->addDays(7);
    }
}
