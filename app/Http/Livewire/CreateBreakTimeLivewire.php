<?php

namespace App\Http\Livewire;

use App\Models\RestSchedule;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use LivewireUI\Modal\ModalComponent;

class CreateBreakTimeLivewire extends ModalComponent
{
    public $scheduleId;
    public $startTime;
    public $endTime;

    public function mount($scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    public function createBreakTime()
    {
        $this->validate([
            'startTime' => 'required',
            'endTime' => [
                'required',
                function($attr, $value, $fail) {
                    $startTime = Carbon::createFromTime(
                        explode(':', $this->startTime)[0],
                        explode(':', $this->startTime)[1],
                    );
                    $endTime = Carbon::createFromTime(
                        explode(':', $this->endTime)[0],
                        explode(':', $this->endTime)[1],
                    );

                    if ($endTime <= $startTime) {
                        $fail("Escoja una hora mayor a hora de inicio");
                    }
                }
            ],
        ]);

        RestSchedule::create([
            'schedule_id' => $this->scheduleId,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime
        ]);

        $employee = Schedule::find($this->scheduleId)->employee;

        session()->flash('flash_success', 'Se agregó con éxito el tiempo de descanso.');

        return redirect()
            ->route('employees.edit', $employee);
    }

    public function render()
    {
        return view('livewire.create-break-time-livewire');
    }
}
