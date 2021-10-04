<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Service;
use App\Notifications\AppointmentConfirmedNotification;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        'location_id' => '',
        'place' => '',
        'full_name' => '',
        'first_name' => '',
        'last_name' => '',
        'phone' => '',
        'email' => '',
        'name_of_child' => '',
        'note' => '',
        'terms_and_conditions' => false,
    ];

    public $employees;

    public $selectedDay;

    public $steps = [];

    public $currentStep = self::STEP_SERVICE_AND_EMPLOYEE;

    protected $listeners = ['updatedDay'];

    public function mount()
    {
        $this->employees = collect();

        array_push($this->steps, self::STEP_SERVICE_AND_EMPLOYEE);
    }

    protected $messages = [
        'form.service_id.required' => 'Seleccione un servicio',
        'form.employee_id.required' => 'Seleccione un profesional',

        'form.start_time.required' => 'Escoje una hora',

        'form.full_name.required' => 'El campo nombres completos es requerido',
        'form.first_name.required' => 'El campo primer apellido Completos es requerido',
        'form.last_name.required' => 'El campo segundo apellido Completos es requerido',
        'form.email.required' => 'El campo email es requerido',
        'form.email.email' => 'El campo email debe ser valido',
        'form.phone.required' => 'El campo teléfono es requerido',
        'form.phone.numeric' => 'El campo teléfono debe solo contener números',
        'form.name_of_child.required' => 'El campo nombre del niño es requerido',
    ];

    public function updatedDay($date, $dontSetHour = true)
    {
        $this->form['date'] = $date;
        if ($dontSetHour) {
            $this->form['start_time'] = '';
        }
        $date = Carbon::createFromDate($date);
        $this->selectedDay = $date->day_name();
    }

    public function stepBack($stepName, $stepIndex)
    {
        $this->currentStep = $stepName;

        $this->steps = collect($this->steps)->forget($stepIndex)->toArray();

        if ($stepName == self::STEP_DATE_AND_HOUR) {
            $this->emit('selectDefaultDay', $this->form['date']);
        }
    }

    public function nextStep($step)
    {
        $this->validate([
            'form.service_id' => 'required',
            'form.employee_id' => 'required',
            'form.location_id' => 'required'
        ]);

        if ($step == self::STEP_DATE_AND_HOUR) {
            $this->emit('selectDefaultDay', '');
        }

        if ($step == self::STEP_DETAILS) {
            $this->validate([
                'form.date' => 'required',
                'form.start_time' => 'required',
            ]);
        }

        if ($step == self::STEP_FAREWELL) {
            $this->validate([
                'form.full_name' => 'required',
                'form.first_name' => 'required',
                'form.last_name' => 'required',
                'form.phone' => [
                    'required',
                    'numeric',
                    function ($attr, $value, $fail) {
                        if (Str::of($value)->length() < 10) {
                            $fail('El campo debe tener al menos 10 digitos');
                        }

                        if (Str::of($value)->length() > 10) {
                            $fail('El campo no debe tener mas de 10 digitos');
                        }
                    }
                ],
                'form.email' => 'required|email',
                'form.name_of_child' => 'required',
                'form.terms_and_conditions' => [
                    function ($attr, $value, $fail) {
                        if (!$value) {
                            $fail('Por favor, antes de seguir, debes aceptar los terminos y condiciones');
                        }
                    }
                ]
            ]);
        }

        if ($step == self::STEP_FAREWELL) {
            $this->createAppointment();
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

    public function getLocationsProperty(): Collection
    {
        if ($this->form['employee_id']) {
            return $this->employee->locations;
        }

        return collect();
    }

    public function getAppointmentDateProperty(): string
    {
        return Carbon::createFromDate($this->form['date'])->day_month_year();
    }

    public function getAppointmentHourProperty(): string
    {
        $hour = explode(':', $this->form['start_time']);

        return Carbon::createFromTime(
            $hour[0],
            $hour[1],
        )->format('H:i A');
    }

    public function getAppointmentLocationProperty()
    {
        if ($this->form['location_id']) {
            return Location::find($this->form['location_id'])->present()->name();
        }

        return $this->service->present()->place();
    }

    public function getAppointmentValueProperty(): string
    {
        return $this->service->present()->value();
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
        if (!$this->form['date']) {
            return [];
        }

        return $this->employee->workingHours($this->form['date'], $this->service, $this->form['location_id']);
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

    public function getServicesProperty()
    {
        return Service::query()->latest()->get();
    }

    public function hourNotAvailableClasses($bool): ?string
    {
        if ($bool) {
            return 'cursor-pointer';
        }

        return 'bg-gray-100 text-gray-400 line-through';
    }

    public function updatedFormServiceId($serviceId)
    {
        $this->form['employee_id'] = '';
        $this->form['location_id'] = '';

        if (!$serviceId) {
            $this->employees = collect();
            return;
        }

        if ($this->service->place) {
            $this->form['place'] = $this->service->place;
        }

        $this->employees = Service::find($this->form['service_id'])->employees;
    }

    public function updatedFormLocationId($locationId)
    {
        if (!$this->form['service_id']) {
            return null;
        }

        if (!$locationId) {
            return null;
        }

        $this->employees = $this->service->employees()
            ->whereHas('schedules', function ($query) use ($locationId) {
                $query->where('location_id', $locationId);
            })
            ->get();
    }

    public function updatedFormEmail($email)
    {
        if (!Str::contains($email, '@')) {
            return null;
        }

        $totalCustomer = Customer::query()
            ->where('email', 'LIKE', "%$email%")
            ->count();

        if ($totalCustomer != 1) {
            return null;
        }

        $customer = Customer::query()
            ->firstWhere('email', 'LIKE', "%$email%");

        $this->form['email'] = $customer->email;
        $this->form['full_name'] = $customer->full_name;
        $this->form['first_name'] = $customer->first_name;
        $this->form['last_name'] = $customer->last_name;
        $this->form['phone'] = $customer->phone;
        $this->form['name_of_child'] = $customer->name_of_child;
    }

    public function createAppointment()
    {
        DB::transaction(function () {
            $customer = Customer::updateOrCreate(
                [
                    'email' => $this->form['email']
                ],
                [
                    'full_name' => $this->form['full_name'],
                    'first_name' => $this->form['first_name'],
                    'last_name' => $this->form['last_name'],
                    'phone' => $this->form['phone'],
                    'name_of_child' => $this->form['name_of_child'],
                    'note' => $this->form['note']
                ]
            );

            $appointment = Appointment::create([
                'employee_id' => $this->form['employee_id'],
                'service_id' => $this->form['service_id'],
                'location_id' => $this->form['location_id'] === ''
                    ? null
                    : $this->form['location_id'],
                'customer_id' => $customer->id,
                'date' => $this->form['date'],
                'start_time' => $this->form['start_time'],
                'note' => $this->form['note'],
            ]);

            $appointment->customer->notify(new AppointmentConfirmedNotification($appointment));
        });
    }

    public function render()
    {
        return view('livewire.appointment-reservation-livewire');
    }
}
