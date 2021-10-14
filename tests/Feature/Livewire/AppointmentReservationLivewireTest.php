<?php

use App\Http\Livewire\AppointmentReservationLivewire;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Notifications\AppointmentConfirmedNotification;
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

function stepOne(TestableLivewire $component, $dataAppointment, $isInAnOffice = true): void
{
    assertCount(1, $component->viewData('steps'));

    $component->assertSet('currentStep', AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE);
    $component->set('form.service_id', $dataAppointment->service_id);
    $component->set('form.employee_id', $dataAppointment->employee_id);
    $component->set('form.location_id', $dataAppointment->location_id);
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
    $component->set('form.date_and_hour.0.date', $dataAppointment->date->format('Y-m-d'));
    $component->set('form.date_and_hour.0.start_time', $dataAppointment->start_time->format('H:i'));
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

    $component->set('form.full_name', $dataCustomer->full_name);
    $component->set('form.first_name', $dataCustomer->first_name);
    $component->set('form.last_name', $dataCustomer->last_name);
    $component->set('form.phone', $dataCustomer->phone);
    $component->set('form.email', $dataCustomer->email);
    $component->set('form.name_of_child', $dataCustomer->name_of_child);
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
    Notification::fake();

    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataAppointment->employee->schedules()
        ->update(['start_time' => '10:00', 'end_time' => '20:00']);

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
    expect($dataCustomer->full_name)->toBe($customer->full_name);
    expect($dataCustomer->first_name)->toBe($customer->first_name);
    expect($dataCustomer->last_name)->toBe($customer->last_name);
    expect($dataCustomer->phone)->toBe($customer->phone);
    expect($dataCustomer->email)->toBe($customer->email);
    expect($dataCustomer->name_of_child)->toBe($customer->name_of_child);

    $appointment = Appointment::first();

    $endTime = $appointment->start_time->addMinutes($dataAppointment->service->duration);

    expect($dataAppointment->service_id)->toBe($appointment->service_id);
    expect($dataAppointment->location_id)->toBe($appointment->location_id);
    expect($dataAppointment->employee_id)->toBe($appointment->employee_id);
    expect($customer->id)->toBe($appointment->customer_id);
    expect($dataAppointment->date->format('Y-m-d'))->toBe($appointment->date->format('Y-m-d'));
    expect($dataAppointment->start_time->format('H:i'))->toBe($appointment->start_time->format('H:i'));
    expect($endTime->format('H:i'))->toBe($appointment->end_time->format('H:i'));

    Notification::assertSentTo($customer, AppointmentConfirmedNotification::class);
});

test('can delete a new date', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataAppointment->employee->schedules()
        ->update(['start_time' => '10:00', 'end_time' => '20:00']);

    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);
    $component->call('addNewDate');

    expect($component->get('form.date_and_hour'))->toHaveCount(2);

    $newDateKey = collect($component->get('form.date_and_hour'))->keys()->last();

    // Act
    $component->call('deleteNewDate', $newDateKey);

    // Assert
    expect($component->get('form.date_and_hour'))->toHaveCount(1);
});

test('fields are required in the first step', function () {
    // Arrange
    $component = buildComponent();

    // STEP ONE
    $component->set('form.service_id', '');
    $component->set('form.employee_id', '');
    $component->set('form.location_id', '');

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);

    // Assert
    $this->assertFalse(
        collect($component->get('steps'))->contains(AppointmentReservationLivewire::STEP_DATE_AND_HOUR)
    );
    $component->assertHasErrors([
        'form.service_id' => 'required',
        'form.employee_id' => 'required',
        'form.location_id' => 'required',
    ]);
});

test('field location_id is required if the  service has locations', function () {
    // Arrange
    $component = buildComponent();
    $service = Service::factory()->create();

    // STEP ONE
    $component->set('form.service_id', $service->id);

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DATE_AND_HOUR);

    // Assert
    $this->assertFalse(
        collect($component->get('steps'))->contains(AppointmentReservationLivewire::STEP_DATE_AND_HOUR)
    );
    $component->assertHasErrors([
        'form.location_id' => 'required',
    ]);
});

test('fields are required in the second step', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->create();
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
    $component = buildComponent();

    // STEP ONE
    stepOne($component, $dataAppointment);

    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_DETAILS);

    // Assert
    $component->assertHasErrors([
        'form.date_and_hour.0.date' => 'required',
        'form.date_and_hour.0.start_time' => 'required',
    ]);
});

test('fields are required in the fourth step', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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
    $component->set('form.full_name', '');
    $component->set('form.first_name', '');
    $component->set('form.last_name', '');
    $component->set('form.phone', '');
    $component->set('form.email', '');
    $component->set('form.name_of_child', '');
    $component->set('form.terms_and_conditions');
    $component->set('form.note', $dataAppointment->note);


    // Act
    $component->call('nextStep', AppointmentReservationLivewire::STEP_FAREWELL);

    // Assert
    $component->assertHasErrors([
        'form.full_name' => 'required',
        'form.first_name' => 'required',
        'form.last_name' => 'required',
        'form.phone' => 'required',
        'form.email' => 'required',
        'form.name_of_child' => 'required',
        'form.terms_and_conditions',
    ]);

    $component->assertHasNoErrors([
        'form.note'
    ]);
});

test('field phone must be a number', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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
        'form.phone' => 'numeric'
    ]);
});

test('field phone must contain at least 10 numbers', function () {
    // Arrange
    $dataAppointment = Appointment::factory()->make();
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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
    $dataAppointment->employee->schedules()->update(['start_time' => '10:00', 'end_time' => '20:00']);
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

test('user can autocomplete his information', function () {
    // Arrange
    $customer = Customer::factory()->create();
    $component = buildComponent();

    // Act
    $component->set('form.email', $customer->email);

    // Assert
    expect($customer->email)->toBe($component->get('form.email'));
    expect($customer->full_name)->toBe($component->get('form.full_name'));
    expect($customer->first_name)->toBe($component->get('form.first_name'));
    expect($customer->last_name)->toBe($component->get('form.last_name'));
    expect($customer->phone)->toBe($component->get('form.phone'));
    expect($customer->name_of_child)->toBe($component->get('form.name_of_child'));
});

test("user can not autocomplete his information if the email does not have string '@'", function () {
    // Arrange
    $customer = Customer::factory()->create();
    $component = buildComponent();

    // Act
    $component->set('form.email', Str::remove('@', $customer->email));

    // Assert
    expect($component->get('form.email'))->not()->toBeNull();
    expect($component->get('form.full_name'))->toBe('');
    expect($component->get('form.first_name'))->toBe('');
    expect($component->get('form.last_name'))->toBe('');
    expect($component->get('form.phone'))->toBe('');
    expect($component->get('form.name_of_child'))->toBe('');
});

test('if there are too many users, the information cannot be autocompleted.', function () {
    // Arrange
    Customer::factory()->create(['email' => 'miguel@gmail.com']);
    Customer::factory()->create(['email' => 'miguel@hotmail.com']);

    $component = buildComponent();

    // Act
    $component->set('form.email', 'miguel@');

    // Assert
    expect($component->get('form.email'))->not()->toBeNull();
    expect($component->get('form.full_name'))->toBe('');
    expect($component->get('form.first_name'))->toBe('');
    expect($component->get('form.last_name'))->toBe('');
    expect($component->get('form.phone'))->toBe('');
    expect($component->get('form.name_of_child'))->toBe('');
});




