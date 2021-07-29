<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class DatePickerLivewire extends Component
{
    public $currentDay;
    public $selectedDay;

    public function mount()
    {
        $this->selectedDay = '';
        $this->currentDay = today()->format('Y-m-d');
    }

    public function isLessThanOrEqualToToday($date): bool
    {
        $date = Carbon::createFromDate($date);

        return $date->lessThan(today());
    }

    public function selectedDayStyles($date): ?string
    {
        if ($this->selectedDay != $date) {
            return null;
        }

        return 'bg-gray-800 text-white rounded-full flex';
    }

    public function dayStyles($date): string
    {
        if ($this->isLessThanOrEqualToToday($date)) {
            return 'font-bold text-gray-400 w-6 h-6';
        }

        if ($this->selectedDay != $date) {
            return "font-bold cursor-pointer text-gray-700 flex justify-center items-center w-6 h-6";
        }

        return "font-bold cursor-pointer flex justify-center items-center w-6 h-6";
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentDay);

        $this->currentDay = $date->addMonth()->format('Y-m-d');
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentDay);

        $this->currentDay = $date->subMonth()->format('Y-m-d');
    }

    public function getMonthNameProperty(): string
    {
        $date = Carbon::createFromDate($this->currentDay);

        return $date->format('F Y');
    }

    public function getIsThePreviousMonthProperty(): bool
    {
        $date = Carbon::createFromDate($this->currentDay);

        return $date->isPast();
    }

    public function selectDay($date)
    {
        $this->selectedDay = $date;
    }

    public function getDaysOfMonthProperty(): Collection
    {
        $daysOfMonth = collect();

        $currentDay = Carbon::createFromFormat('Y-m-d', $this->currentDay);

        $firstDayOfMonth = $currentDay->copy()->firstOfMonth();
        $lastDayOfMonth = $currentDay->copy()->lastOfMonth();

        while ($firstDayOfMonth->dayOfWeek !== 1) {
            $firstDayOfMonth->subDay();
        }

        while ($lastDayOfMonth->dayOfWeek !== 0) {
            $lastDayOfMonth->addDay();
        }

        while ($firstDayOfMonth <= $lastDayOfMonth) {
            $daysOfMonth->put($firstDayOfMonth->format('Y-m-d'), $firstDayOfMonth->day);

            $firstDayOfMonth->addDay();
        }

        return $daysOfMonth;
    }

    public function render()
    {
        return view('livewire.date-picker-livewire');
    }
}
