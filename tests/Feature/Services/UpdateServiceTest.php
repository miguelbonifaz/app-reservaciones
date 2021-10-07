<?php

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function updateService(Service $service, $data = [])
{
    $url = route('services.update' ,$service);

    return test()->actingAsUser()->post($url, $data);
}

test('can see service edit form', function () {
    // Arrange
    $service = Service::factory()->create();

    // Act
    $url = route('services.edit', $service);

    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('services.edit');

    $response->assertViewHas('service');
});

test('can update a service', function () {

    // Arrange
    $service = Service::factory()->create();

    $data = Service::factory()->make();

    // Act
    $response = updateService($service,[
        'name' => $data->name,
        'duration' => $data->duration,
        'value' => $data->value,
        'description' => $data->description,
        'place' => $data->place,
        'slots' => $data->slots
    ]);

    // Assert
    $response->assertRedirect(route('services.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el servicio.');

    $this->assertCount(1, Service::all());

    $service = Service::first();

    $this->assertEquals($data->name, $service->name);
    $this->assertEquals($data->duration, $service->duration);
    $this->assertEquals($data->value, $service->value);
    $this->assertEquals($data->description, $service->description);
    $this->assertEquals($data->place, $service->place);
    $this->assertEquals($data->slots, $service->slots);
});

test('fields are required', function () {
    // Arrange
    $service = Service::factory()->create();

    //Act
    $response = updateService($service,[
        'name' => null,
        'duration' => null,
        'description' => null,
        'value' => null,
        'slots' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'duration',
        'value',
        'description',
        'slots'
    ]);

    $response->assertSessionDoesntHaveErrors(['place']);
});

test('field duration and slot must be a number', function () {
    // Arrange
    $service = Service::factory()->create();

    // Act
    $response = updateService($service,[
        'duration' => 'string',
        'slots' => 'string',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'duration',
        'slots',
    ]);
});

