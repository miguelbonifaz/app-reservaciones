<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;

class CreateAppointmentsLivewire extends Component
{

    public $customer_id;
    public $service_id;
    public $employee_id;

    public $start_time;
    public $date;
    public $note;

    public $cancelUrl;
    public $returnUrl;
    public $AppointmentId;

    public $listeners = [
        'customer_idUpdated',
        'service_idUpdated',
        'employee_idUpdated'
    ];

    public function customer_idUpdated($data)
    {
        $this->customer_id = $data['value'];
    }

    public function service_idUpdated($data)
    {
        $this->service_id = $data['value'];
    }

    public function employee_idUpdated($data)
    {
        $this->employee_id = $data['value'];
    }


    public function mount($cancelUrl = null, $AppointmentId = null, $returnUrl = null)
    {
        $this->cancelUrl = $cancelUrl ?? route('calendar.index');
        $this->returnUrl = $returnUrl ?? route('calendar.index');
    }

    public function onSubmit()
    {
        $this->validate([
            'customer_id' => [
                'required',
                'exists:customers,id'
            ],
            'service_id' => [
                'required',
                'exists:services,id'
            ],
            'employee_id' => [
                'required',
                'exists:employees,id'
            ],
            'start_time' => [
                'required',
            ],
            'date' => [
                'required',
            ],
        ]);

        $service = Service::find($this->service_id);

        $startTime = $this->start_time . ':00';

        $endTime = Carbon::createFromFormat('H:i:s', $this->start_time . ':00')->addMinutes($service->duration)->format('H:i:s');

        Appointment::create([
            'customer_id' => $this->customer_id,
            'service_id' => $this->service_id,
            'employee_id' => $this->employee_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $this->date,
            'note' => $this->note,
        ]);

        session()->flash('flash_success', 'Se creó con exito la reservación');

        return redirect()->to($this->returnUrl);
    }

    public function render()
    {
        return view('livewire.create-appointments-livewire');
    }
}
