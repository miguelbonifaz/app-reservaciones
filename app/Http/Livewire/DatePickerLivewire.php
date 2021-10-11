<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class DatePickerLivewire extends Component
{
    public $currentDay;
    public $selectedDay;
    public $employeeId;
    public $locationId;

    protected $listeners = ['selectDefaultDay'];

    public function mount($employeeId, $locationId)
    {
        $this->locationId = $locationId;
        $this->employeeId = $employeeId;

        $this->selectedDay = '';
        $this->currentDay = today()->format('Y-m-d');
    }

    public function isGreaterThanToday($date): bool
    {
        $date = Carbon::createFromDate($date);

        return $date->lessThan(today()->addDay());
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

        $location = Location::find($this->locationId);

        if (!collect($employee->businessDays($location))->contains($selectedDay->dayOfWeek)) {
            return true;
        }

        return false;
    }

    public function isThisDayAvailable($date): bool
    {
        if ($this->isGreaterThanToday($date)) {
            return false;
        }

        if ($this->isInBusinessDays($date)) {
            return false;
        }

        return true;
    }

    public function dayStyles($date): string
    {
        if ($this->isGreaterThanToday($date) || $this->isInBusinessDays($date)) {
            return 'text-gray-400';
        }

        if ($this->selectedDay != $date) {
            return "cursor-pointer text-gray-700";
        }

        return "cursor-pointer";
    }

    public function selectDefaultDay($date = null)
    {
        $employee = Employee::find($this->employeeId);

        $date = $date == ''
            ? today()
            : Carbon::createFromDate($date);

        $location = Location::find($this->locationId);
        while (!$employee->businessDays($location)->contains($date->dayOfWeek)) {
            $date->addDay();
        }

        $this->selectedDay = $date->addDay()->format('Y-m-d');

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

        return Str::of($date->getTranslatedMonthName())->ucfirst() . " {$date->format('Y')}";
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
