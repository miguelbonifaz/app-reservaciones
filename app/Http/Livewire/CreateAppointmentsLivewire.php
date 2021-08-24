<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Employee;
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

    protected $listeners = ['updatedDay'];

    public function updatedDay($date, $dontSetHour = true)
    {
        $this->form['date'] = $date;
        $date = Carbon::createFromDate($date);
        $this->selectedDay = $date->format('l j');
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
        if (!$this->form['employee_id']) {
            return collect();
        }

        return $this->employee
            ->workingHours($this->form['date'], $this->service)
            ->filter(function ($hour) {
                return $hour['isAvailable'];
            });
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

        return redirect()->to('calendar.index');
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
