<?php

use App\Http\Livewire\AppointmentReservationLivewire;
use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

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

function stepOne(TestableLivewire $component, $dataAppointment): void
{
    assertCount(1, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE);
    $component->set('form.service_id', $dataAppointment->service_id);
    $component->set('form.employee_id', $dataAppointment->employee_id);
    assertNull($component->get('firstStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('secondStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('thirdStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fourthStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fifthStepProgressBarClass'));

    $component->call('nextStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);
}

function stepTwo(TestableLivewire $component, $dataAppointment): void
{
    assertCount(2, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);
    $component->set('form.date', $dataAppointment->date->format('Y-m-d'));
    $component->set('form.start_time', $dataAppointment->start_time->format('H:i'));
    assertNull($component->get('firstStepProgressBarClass'));
    assertNull($component->get('secondStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('thirdStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fourthStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fifthStepProgressBarClass'));

    $component->call('nextStep', AppointmentReservationLivewire::STEP_DETAILS);
}

function stepThree(TestableLivewire $component): void
{
    assertCount(3, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_DETAILS);
    assertNull($component->get('firstStepProgressBarClass'));
    assertNull($component->get('secondStepProgressBarClass'));
    assertNull($component->get('thirdStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fourthStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fifthStepProgressBarClass'));

    $component->call('nextStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
}

function stepFourth(TestableLivewire $component, $dataCustomer, $dataAppointment): void
{
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.name', $dataCustomer->name);
    $component->set('form.phone', $dataCustomer->phone);
    $component->set('form.email', $dataCustomer->email);
    $component->set('form.note', $dataAppointment->note);
    $component->set('form.terms_and_conditions', true);
    assertNull($component->get('firstStepProgressBarClass'));
    assertNull($component->get('secondStepProgressBarClass'));
    assertNull($component->get('thirdStepProgressBarClass'));
    assertNull($component->get('fourthStepProgressBarClass'));
    assertEquals('opacity-30', $component->get('fifthStepProgressBarClass'));

    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);
}

function stepFive(TestableLivewire $component): void
{
    assertCount(5, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FAREWELL);
    assertNull($component->get('firstStepProgressBarClass'));
    assertNull($component->get('secondStepProgressBarClass'));
    assertNull($component->get('thirdStepProgressBarClass'));
    assertNull($component->get('fourthStepProgressBarClass'));
    assertNull($component->get('fifthStepProgressBarClass'));
}

test('can create an appointment', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataCustomer = Customer::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    stepFourth($component, $dataCustomer, $dataAppointment);

    // STEP FIVE
    stepFive($component);

    // Assert
    $this->assertCount(1, Appointment::all());
    $this->assertCount(2, Customer::all());

    $customer = Customer::firstWhere('email', $dataCustomer->email);
    expect($dataCustomer->name)->toBe($customer->name);
    expect($dataCustomer->phone)->toBe($customer->phone);
    expect($dataCustomer->email)->toBe($customer->email);

    $appointment = Appointment::first();

    $endTime = $appointment->start_time->addMinutes($dataAppointment->service->duration);

    expect($dataAppointment->service_id)->toBe($appointment->service_id);
    expect($dataAppointment->employee_id)->toBe($appointment->employee_id);
    expect($customer->id)->toBe($appointment->customer_id);
    expect($dataAppointment->date->format('Y-m-d'))->toBe($appointment->date->format('Y-m-d'));
    expect($dataAppointment->start_time->format('H:i'))->toBe($appointment->start_time->format('H:i'));
    expect($endTime->format('H:i'))->toBe($appointment->end_time->format('H:i'));
});

test('fields are required in the first step', function () {
    // Arrange
    $component = buildComponent();

    // STEP ONE
    $component->set('form.service_id', '');
    $component->set('form.employee_id', '');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);

    // Assert
    $this->assertFalse(
        collect($component->get('steps'))->contains(AppointmentReservationLivewire::STEP_DATE_AND_HOUR)
    );
    $component->assertHasErrors([
        'form.service_id' => 'required',
        'form.employee_id' => 'required'
    ]);
});

test('fields are required in the second step', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->create();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DETAILS);

    // Assert
    $component->assertHasErrors([
        'form.date' => 'required',
        'form.start_time' => 'required',
    ]);
});

test('fields are required in the fourth step', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.name', '');
    $component->set('form.phone', '');
    $component->set('form.email', '');
    $component->set('form.terms_and_conditions');
    $component->set('form.note', $dataAppointment->note);


    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
        'form.name' => 'required',
        'form.phone' => 'required',
        'form.email' => 'required',
        'form.terms_and_conditions',
    ]);

    $component->assertHasNoErrors([
       'form.note'
    ]);
});

test('field phone must be a number', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.phone', 'string');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
       'form.phone'  => 'numeric'
    ]);
});

test('field phone must contain at least 10 numbers', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.phone', '096820430');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
       'form.phone'
    ]);
});

test('field phone must not contain more than 10 numbers', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.phone', '09682043000');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
       'form.phone'
    ]);
});

test('field email must be valid', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.email', 'not-email');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
       'form.email' => 'email'
    ]);
});

test('field terms_and_conditions is required', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // STEP TWO
    stepTwo($component, $dataAppointment);

    // STEP THREE
    stepThree($component);

    // STEP FOURTH
    assertCount(4, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_FORM_CUSTOMER);
    $component->set('form.terms_and_conditions', false);

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
       'form.terms_and_conditions'
    ]);
});




