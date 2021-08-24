<?php

use App\Http\Livewire\CreateAppointmentsLivewire;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildAppointmentComponent(): TestableLivewire
{
    test()->actingAsUser();

    return livewire(CreateAppointmentsLivewire::class);
}

test('can see create appointment form', function () {
    // Arrange
    $this->withoutExceptionHandling();

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
    $component = buildAppointmentComponent();
    // Assert
    $this->assertNotNull($component);
});

test('can create an appointment', function () {
    // Arrange
    $data = Appointment::factory()->make();

    $component = buildAppointmentComponent();

    $component->set('form.customer_id', $data->customer_id);
    $component->set('form.service_id', $data->service_id);
    $component->set('form.location_id', $data->location_id);
    $component->set('form.employee_id', $data->employee_id);
    $component->set('form.start_time', $data->start_time->format('H:i'));
    $component->set('form.date', $data->date->format('Y-m-d'));
    $component->set('form.note', $data->note);

    // Act
    $component->call('onSubmit');

    // Assert
    $this->assertCount(1, Appointment::all());

    $appointment = Appointment::first();

    expect($data->customer_id)->toEqual($appointment->customer_id);
    expect($data->service_id)->toEqual($appointment->service_id);
    expect($data->employee_id)->toEqual($appointment->employee_id);
    expect($data->location_id)->toEqual($appointment->location_id);
    expect($data->start_time->format('H:i'))->toEqual($appointment->start_time->format('H:i'));
    expect($data->date)->toEqual($appointment->date);
    expect($data->note)->toEqual($appointment->note);
});

test('fields are required', function () {
    // Arrange
    $component = buildAppointmentComponent();

    $component->set('form.customer_id', null);
    $component->set('form.service_id', null);
    $component->set('form.employee_id', null);
    $component->set('form.start_time', null);
    $component->set('form.date', null);

    // Act
    $component->call('onSubmit');

    // Assert
    $component->assertHasErrors([
        'form.customer_id' => 'required',
        'form.service_id' => 'required',
        'form.employee_id' => 'required',
        'form.start_time' => 'required',
        'form.date' => 'required',
    ]);
});
