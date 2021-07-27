<?php

use App\Http\Livewire\AppointmentReservationLivewire;
use App\Http\Livewire\CreateBreakTimeLivewire;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\RestSchedule;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildComponent(): TestableLivewire
{
    return livewire(AppointmentReservationLivewire::class);
}

test('can create component', function () {
    // Arrange

    // Act
    $component = buildComponent();

    // Assert
    expect($component)->not()->toBeNull();
});

test('can creat an appointment', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataCustomer = Customer::factory()->make();
    $component = buildComponent();

    // STEP ONE
    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE);
    $component->set('form.service_id', $dataAppointment->service_id);
    $component->set('form.employee_id', $dataAppointment->employee_id);
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);

    // STEP TWO
    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);
    $component->set('form.date', $dataAppointment->date->format('Y-m-d'));
    $component->set('form.start_time', Carbon::createFromTimestamp($dataAppointment->start_time)->format('H:i'));
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DETAILS);

    // STEP THREE
    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_DETAILS);
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FORM_DETAIL);

    // STEP FOURTH
    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_DETAIL);
    $component->set('form.name', $dataCustomer->name);
    $component->set('form.phone', $dataCustomer->phone);
    $component->set('form.email', $dataCustomer->email);
    $component->set('form.identification_number', $dataCustomer->identification_number);
    $component->set('form.note', $dataAppointment->note);
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // STEP FIVE
    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Act
    $component->call('createAppointment');

    // Assert
    $this->assertCount(1, Appointment::all());
    $this->assertCount(2, Customer::all());

    $customer = Customer::firstWhere('email', $dataCustomer->email);
    expect($dataCustomer->name)->toBe($customer->name);
    expect($dataCustomer->phone)->toBe($customer->phone);
    expect($dataCustomer->email)->toBe($customer->email);
    expect($dataCustomer->identification_number)->toBe($customer->identification_number);

    $appointment = Appointment::first();

    $endTime = Carbon::createFromTimestamp($appointment->start_time)->addMinutes($dataAppointment->service->duration)->timestamp;

    expect($dataAppointment->service_id)->toBe($appointment->service_id);
    expect($dataAppointment->employee_id)->toBe($appointment->employee_id);
    expect($customer->id)->toBe($appointment->customer_id);
    expect($dataAppointment->date->format('Y-m-d'))->toBe($appointment->date->format('Y-m-d'));
    expect($dataAppointment->start_time)->toBe($appointment->start_time);
    expect($endTime)->toBe($appointment->end_time);
});


