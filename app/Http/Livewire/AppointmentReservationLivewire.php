<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AppointmentReservationLivewire extends Component
{
    public const STEP_SERVICE_AND_EMPLOYEE = 'step_service_and_employee';
    public const STEP_DATE_AND_HOUR = 'step_date_and_hour';
    public const STEP_DETAILS = 'step_date_and_hour';
    public const STEP_FORM_DETAIL = 'step_form_detail';
    public const STEP_FAREWELL = 'step_form_detail';

    public const STEPS = [
        self::STEP_SERVICE_AND_EMPLOYEE,
        self::STEP_DATE_AND_HOUR,
        self::STEP_DETAILS,
        self::STEP_FORM_DETAIL,
        self::STEP_FAREWELL,
    ];

    public $currentStep = self::STEP_SERVICE_AND_EMPLOYEE;

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

    public function nextStep($step)
    {
        $this->currentStep = $step;
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
                'service_id' => $this->form['service_id'],
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
