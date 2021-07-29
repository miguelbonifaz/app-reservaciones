<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AppointmentReservationLivewire extends Component
{
    public const STEP_SERVICE_AND_EMPLOYEE = 'step_service_and_employee';
    public const STEP_DATE_AND_HOUR = 'step_date_and_hour';
    public const STEP_DETAILS = 'step_details';
    public const STEP_FORM_CUSTOMER = 'step_form_customer';
    public const STEP_FAREWELL = 'step_farewell';

    public const STEPS = [
        self::STEP_SERVICE_AND_EMPLOYEE,
        self::STEP_DATE_AND_HOUR,
        self::STEP_DETAILS,
        self::STEP_FORM_CUSTOMER,
        self::STEP_FAREWELL,
    ];

    public $form = [
        'service_id' => '',
        'employee_id' => '',
        'date' => '',
        'start_time' => '',
        'name' => '',
        'phone' => '',
        'email' => '',
        'identification_number' => '',
        'note' => '',
    ];

    public $employees;

    public $currentStep = self::STEP_SERVICE_AND_EMPLOYEE;

    public function mount()
    {
        $this->employees = collect();
    }

    public function nextStep($step)
    {
        $this->validate([
            'form.service_id' => 'required',
            'form.employee_id' => 'required',
        ]);

        $this->currentStep = $step;
    }

    public function stepBack($step)
    {
        $this->currentStep = $step;
    }

    public function getServicesProperty()
    {
        return Service::all();
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

    public function createAppointment()
    {
        DB::transaction(function () {
            $customer = Customer::create([
                'name' => $this->form['name'],
                'phone' => $this->form['phone'],
                'email' => $this->form['email'],
                'identification_number' => $this->form['identification_number'],
                'note' => $this->form['note'],
            ]);

            Appointment::create([
                'employee_id' => $this->form['employee_id'],
                'service_id' => $this->form['service'],
                'customer_id' => $customer->id,
                'date' => $this->form['date'],
                'start_time' => $this->form['start_time'],
                'note' => $this->form['note'],
            ]);
        });
    }

    public function render()
    {
        return view('livewire.appointment-reservation-livewire');
    }
}
