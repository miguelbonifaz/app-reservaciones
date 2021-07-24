<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Asantibanez\LivewireResourceTimeGrid\LivewireResourceTimeGrid;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

    public function resources(): Collection
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

        return Appointment::query()
            ->whereDate('date', '<=', $endOfWeek)
            ->whereDate('date', '>=', $startOfWeek)
            ->get()
            ->map(function (Appointment $appointment) {
                $appointment->load('customer');

                return [
                    'id' => $appointment->id,
                    'title' => $appointment->customer->present()->name(),
                    'starts_at' => Carbon::createFromTimestamp($appointment->start_time),
                    'ends_at' => Carbon::createFromTimestamp($appointment->end_time),
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

    public function styles(): array
    {
        return [
            'intersect' => 'border',

            'hourAndSlotsContainer' => 'border relative -mt-px bg-gray-100',

            'hourWrapper' => 'border relative -mt-px bg-white',

            'hour' => 'p-2 text-sm text-gray-600 flex justify-center items-center',

            'resourceColumnHeader' => 'h-full text-gray-800 flex justify-center items-center',

            'resourceColumnHourSlot' => 'border-b hover:bg-blue-100 cursor-pointer',

            'eventWrapper' => 'absolute top-0 left-0',

            'event' => 'rounded h-full flex flex-col overflow-hidden w-full shadow-lg border',

            'eventTitle' => 'text-xs font-medium bg-indigo-500 p-2 text-white',

            'eventBody' => 'text-xs bg-white flex-1 p-2',
        ];
    }
}
