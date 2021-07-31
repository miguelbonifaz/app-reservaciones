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

    public $steps = [];

    public $currentStep = self::STEP_SERVICE_AND_EMPLOYEE;

    public $queryString = ['currentStep'];

    public function mount()
    {
        $this->employees = collect();

        array_push($this->steps, self::STEP_SERVICE_AND_EMPLOYEE);
    }

    public function nextStep($step)
    {
        $this->validate([
            'form.service_id' => 'required',
            'form.employee_id' => 'required',
        ]);

        array_push($this->steps, $step);

        $this->currentStep = $step;
    }

    public function isInTheFirstStep(): bool
    {
        if (collect($this->steps)->contains(self::STEP_SERVICE_AND_EMPLOYEE)) {
            return true;
        }

        return false;
    }

    public function isInTheSecondStep(): bool
    {
        if (collect($this->steps)->contains(self::STEP_DATE_AND_HOUR)) {
            return true;
        }

        return false;
    }

    public function isInTheThirdStep(): bool
    {
        if (collect($this->steps)->contains(self::STEP_DETAILS)) {
            return true;
        }

        return false;
    }

    public function isInTheFourthStep(): bool
    {
        if (collect($this->steps)->contains(self::STEP_FORM_CUSTOMER)) {
            return true;
        }

        return false;
    }

    public function isInTheFifthStep(): bool
    {
        if (collect($this->steps)->contains(self::STEP_FAREWELL)) {
            return true;
        }

        return false;
    }

    public function getFirstStepProgressBarClassProperty(): ?string
    {
        if ($this->isInTheFirstStep()) {
            return null;
        }

        return 'opacity-30';
    }

    public function getSecondStepProgressBarClassProperty(): ?string
    {
        if ($this->isInTheFirstStep() && $this->isInTheSecondStep()) {
            return null;
        }

        return 'opacity-30';
    }

    public function getThirdStepProgressBarClassProperty(): ?string
    {
        if ($this->isInTheFirstStep() && $this->isInTheSecondStep() && $this->isInTheThirdStep()) {
            return null;
        }

        return 'opacity-30';
    }

    public function getFourthStepProgressBarClassProperty(): ?string
    {
        if (
            $this->isInTheFirstStep() &&
            $this->isInTheSecondStep() &&
            $this->isInTheThirdStep() &&
            $this->isInTheFourthStep()) {
            return null;
        }

        return 'opacity-30';
    }

    public function getFifthStepProgressBarClassProperty(): ?string
    {
        if (
            $this->isInTheFirstStep() &&
            $this->isInTheSecondStep() &&
            $this->isInTheThirdStep() &&
            $this->isInTheFourthStep() &&
            $this->isInTheFifthStep()) {
            return null;
        }

        return 'opacity-30';
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
