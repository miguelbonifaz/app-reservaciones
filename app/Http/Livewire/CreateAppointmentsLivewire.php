<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class CreateAppointmentsLivewire extends Component
{
    public $employees = [];

    public $form = [
        'service_id' => '',
        'employee_id' => '',
        'start_time' => '',
        'location_id' => '',
        'date' => '',
        'customer_id' => '',
        'note' => '',
    ];

    protected $listeners = ['updatedDay', 'customer_idUpdated'];

    public function customer_idUpdated($data)
    {
        $this->form['customer_id'] = $data['value'];
    }

    public function updatedDay($date)
    {
        $this->form['location_id'] = '';
        $this->form['start_time'] = '';
        $this->form['date'] = $date;
    }

    public function updatedFormStartTime($hour)
    {
        $this->availableHours
            ->filter(function (Collection $hours, $location) use ($hour) {
                $hours = $hours->map(fn($data) => $data['hour']);

                if ($hours->contains($hour)) {
                    $this->form['location_id'] = Location::firstWhere('name', $location)->id;
                }
            });
    }

    public function updatedFormServiceId($serviceId)
    {
        $this->form['employee_id'] = '';

        if (!$serviceId) {
            $this->employees = collect();
            return;
        }

        $this->employees = Service::find($this->form['service_id'])->employees;
    }

    public function getAvailableHoursProperty(): Collection
    {
        if (!$this->form['employee_id'] || !$this->form['date']) {
            return collect();
        }

        return $this->employee
            ->workingHours($this->form['date'], $this->service, $this->form['location_id'])
            ->map(fn($data) => $data['hour']);
    }

    public function getEmployeeProperty()
    {
        return Employee::find($this->form['employee_id']);
    }

    public function getServiceProperty()
    {
        return Service::find($this->form['service_id']);
    }

    public function getServicesProperty()
    {
        return Service::query()->latest()->get();
    }

    public function getLocationsProperty()
    {
        if (!$this->form['employee_id']) {
            return [];
        }

        return $this->employee->locations;
    }

    public function onSubmit()
    {
        $this->validate([
            'form.customer_id' => [
                'required',
                'exists:customers,id'
            ],
            'form.service_id' => [
                'required',
                'exists:services,id'
            ],
            'form.employee_id' => [
                'required',
                'exists:employees,id'
            ],
            'form.location_id' => [
                'required',
            ],
            'form.start_time' => [
                'required',
            ],
            'form.date' => [
                'required',
            ],
        ]);

        Appointment::create([
            'customer_id' => $this->form['customer_id'],
            'service_id' => $this->form['service_id'],
            'employee_id' => $this->form['employee_id'],
            'location_id' => $this->form['location_id'],
            'start_time' => $this->form['start_time'],
            'end_time' => $this->createEndTime($this->form['start_time']),
            'date' => $this->form['date'],
            'note' => $this->form['note'],
        ]);

        session()->flash('flash_success', 'Se creó con exito la reservación');

        $this->redirect(route('calendar.index'));
    }

    public function render()
    {
        return view('livewire.create-appointments-livewire');
    }

    private function createEndTime($startTime): string
    {
        $time = explode(':', $startTime);
        $startTime = Carbon::createFromTime($time[0], $time[1]);

        return $startTime->copy()->addMinutes($this->service->duration)->format('H:i');
    }
}
