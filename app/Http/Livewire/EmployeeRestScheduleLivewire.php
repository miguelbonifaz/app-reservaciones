<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use Livewire\Component;

class EmployeeRestScheduleLivewire extends Component
{    
    public $day;
    public $rests = [];
    

    public function mount($day)
    {    
        $this->day = $day;        
    }

    public function addRest()
    {        
        $this->rests[] = '';        
    }

    public function removeRest($key)
    {        
        unset($this->rests[$key]);
        $this->rests[] = array_values($this->rests);        
    }

    public function render()
    {        
        $rests[] = $this->rests;
        /* dd($rests[]); */
        $restPerDay =collect([$this->day => $this->rests]);
        
        return view('livewire.employee-rest-schedule-livewire');        
    }
}
