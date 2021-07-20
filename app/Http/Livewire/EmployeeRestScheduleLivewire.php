<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use Illuminate\Support\Str;
use Livewire\Component;

class EmployeeRestScheduleLivewire extends Component
{
    public $day = [];
    public $rests = [];

    public function mount($day)
    {
        $this->day = $day;
    }

    public function addRest()
    {
        $this->rests = collect($this->rests)
            ->push(Str::uuid());
    }

    public function render()
    {
        return view('livewire.employee-rest-schedule-livewire');
    }
}
