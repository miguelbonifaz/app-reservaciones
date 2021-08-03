<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class SelectWithHours extends Component
{
    public Carbon $startTime;
    public Carbon $endTime;
    public $hours = [];
    public $label;
    public $placeholder;
    public $name;
    public $value;

    public function __construct($name, $placeholder = 'Escoja una opción...', $label = false, $startTime = [8, 0], $endTime = [21, 0], $minuteSteps = 30, $value = null)
    {
        $this->startTime = today()->setTime($startTime[0], $startTime[1]);
        $this->endTime = today()->setTime($endTime[0], $endTime[1]);
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->name = $name;

        if ($value) {
            $this->value = Carbon::createFromTimestamp($value)->format('H:i');
        }

        while ($this->startTime <= $this->endTime) {
            $this->hours = collect($this->hours)
                ->push($this->startTime->format('H:i'));

            $this->startTime->addMinutes($minuteSteps);
        }
    }

    public function render()
    {
        return view('components.select-with-hours');
    }
}
