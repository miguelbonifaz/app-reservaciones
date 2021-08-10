<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class DatePickerLivewire extends Component
{
    public $currentDay;
    public $selectedDay;
    public $employeeId;

    protected $listeners = ['selectDefaultDay'];

    public function mount($employeeId)
    {
        $this->employeeId = $employeeId;

        $this->selectedDay = '';
        $this->currentDay = today()->format('Y-m-d');
    }

    public function isLessThanToday($date): bool
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

    public function isInBusinessDays($date): bool
    {
        $employee = Employee::find($this->employeeId);

        $selectedDay = Carbon::createFromDate($date);

        if (!$selectedDay || !$employee) {
            return false;
        }

        if (!collect($employee->businessDays())->contains($selectedDay->dayOfWeek)) {
            return true;
        }

        return false;
    }

    public function isThisDayAvailable($date): bool
    {
        if ($this->isLessThanToday($date)) {
            return false;
        }

        if ($this->isInBusinessDays($date)) {
            return false;
        }

        return true;
    }

    public function dayStyles($date): string
    {
        if ($this->isLessThanToday($date) || $this->isInBusinessDays($date)) {
            return 'text-gray-400';
        }

        if ($this->selectedDay != $date) {
            return "cursor-pointer text-gray-700";
        }

        return "cursor-pointer";
    }

    public function selectDefaultDay($date)
    {
        $employee = Employee::find($this->employeeId);

        $date = $date == ''
            ? today()
            : Carbon::createFromDate($date);

        while (!$employee->businessDays()->contains($date->dayOfWeek)) {
            $date->addDay();
        }

        $this->selectedDay = $date->format('Y-m-d');

        $this->emit('updatedDay', $date->format('Y-m-d'), $dontSetHour = false);
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

        $this->emitUp('updatedDay', $date);
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
