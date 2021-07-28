<?php

use App\Http\Livewire\CreateAppointmentsLivewire;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildComponent($cancelUrl = null, $appointmentId = null, $returnUrl = null): TestableLivewire
{
    test()->actingAsUser();

    return livewire(CreateAppointmentsLivewire::class, [
        'cancelUrl' => $cancelUrl,
        'appointmentId' => $appointmentId,
        'returnUrl' => $returnUrl
    ]);
}

test('can see create appointment form', function () {
    // Arrange
    // Act
    $url = route('appointments.create');

    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('appointments.create');

    $response->assertViewHas('appointment');
});

test('can create component', function () {
    // Arrange
    // Act
    $component = buildComponent();
    // Assert
    $this->assertNotNull($component);
});

test('can create an appointment', function () {
    // Arrange
    $data = Appointment::factory()->make();

    // Act
    $component = buildComponent();

    $component->set('customer_id', $data->customer_id);
    $component->set('service_id', $data->service_id);
    $component->set('employee_id', $data->employee_id);

    $component->set('start_time', Carbon::createFromTimestamp($data->start_time)->format('H:i'));

    $component->set('date', $data->date);
    $component->set('note', $data->note);

    // Act
    $component->call('onSubmit');

    // Assert
    $this->assertCount(1, Appointment::all());

    $appointment = Appointment::first();

    expect($data->customer_id)->toEqual($appointment->customer_id);
    expect($data->service_id)->toEqual($appointment->service_id);
    expect($data->employee_id)->toEqual($appointment->employee_id);

    expect($data->start_time)->toEqual($appointment->start_time);

    expect($data->date)->toEqual($appointment->date);
    expect($data->note)->toEqual($appointment->note);
});

test('fields are required', function () {
    // Arrange
    $component = buildComponent();

    $component->set('customer_id', null);
    $component->set('service_id', null);
    $component->set('employee_id', null);

    $component->set('start_time', null);

    $component->set('date', null);

    // Act
    $component->call('onSubmit');

    // Assert
    $component->assertHasErrors([
        'customer_id' => 'required',
        'service_id' => 'required',
        'employee_id' => 'required',
        'start_time' => 'required',
        'date' => 'required',
    ]);
});
