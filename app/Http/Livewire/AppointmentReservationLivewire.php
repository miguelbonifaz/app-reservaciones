<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
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

    public $selectedDay;

    public $steps = [];

    public $currentStep = self::STEP_SERVICE_AND_EMPLOYEE;

    public $queryString = ['currentStep'];

    protected $listeners = ['updatedDay'];

    public function mount()
    {
        $this->employees = collect();

        array_push($this->steps, self::STEP_SERVICE_AND_EMPLOYEE);
    }

    public function updatedDay($date)
    {
        $this->form['date'] = $date;
        $this->form['start_time'] = '';
        $date = Carbon::createFromDate($date);
        $this->selectedDay = $date->format('l j');
    }

    public function nextStep($step)
    {
        $this->validate([
            'form.service_id' => 'required',
            'form.employee_id' => 'required',
        ]);

        if ($step == self::STEP_DETAILS) {
            $this->validate([
                'form.date' => 'required',
                'form.start_time' => 'required',
            ]);
        }

        if (self::STEP_DATE_AND_HOUR) {
            $this->emit('selectDefaultDay');
        }

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

    public function getEmployeeProperty()
    {
        return Employee::find($this->form['employee_id']);
    }

    public function getServiceProperty()
    {
        return Service::find($this->form['service_id']);
    }

    public function getAvailableHoursProperty()
    {
        return $this->employee->workingHours($this->form['date'], $this->service);
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

    public function hourNotAvailableClasses($bool): ?string
    {
        if ($bool) {
            return 'cursor-pointer';
        }

        return 'bg-gray-100 text-gray-400 line-through';
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
