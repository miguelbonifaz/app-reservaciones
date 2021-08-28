<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class AssignNewLocationToAnEmployeeLivewire extends ModalComponent
{
    public $employeeId;
    public $locationId;

    public function mount($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function getLocationsProperty()
    {
        $employee = Employee::find($this->employeeId);

        return Location::query()
            ->whereNotIn('id', $employee->locations->pluck('id'))
            ->get();
    }

    public function assignLocation()
    {
        DB::transaction(function () {
            $employee = Employee::find($this->employeeId);

            $employee->locations()->attach([$this->locationId]);

            $days = collect([0, 1, 2, 3, 4, 5, 6]);

            $days->each(function ($day) use ($employee) {
                $employee->schedules()->create([
                    'day' => $day,
                    'employee_id' => $employee->id,
                    'location_id' => $this->locationId
                ]);
            });
        });

        session()->flash('flash_success', 'Se agregó con éxito la localidad');

        return redirect()
            ->route('employees.edit', $this->employeeId);
    }

    public function render()
    {
        return view('livewire.assign-new-location-to-an-employee-livewire');
    }
}
