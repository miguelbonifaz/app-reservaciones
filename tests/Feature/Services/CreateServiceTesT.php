<?php

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function createService($data = [])
{
    $url = route('services.store');

    return test()->actingAsUser()->post($url, $data);
}

test('can see service create form', function () {
    // Arrange

    // Act
    $url = route('services.create');

    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('services.create');

    $response->assertViewHas('service');
});

test('can create a service', function () {
    // Arrange
    $data = Service::factory()->make();

    // Act
    $response = createService([
        'name' => $data->name,
        'duration' => $data->duration,
        'value' => $data->value
    ]);

    // Assert
    $response->assertRedirect(route('services.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el servicio.');

    $this->assertCount(1, Service::all());

    $service = Service::first();

    $this->assertEquals($data->name, $service->name);
    $this->assertEquals($data->duration, $service->duration);
    $this->assertEquals($data->value, $service->value);
});

test('fields are required', function () {
    // Arrange
    //Act
    $response = createService([
        'name' => null,
        'duration' => null,
        'value' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'duration',
        'value'
    ]);
});

test('field duration must be a number', function () {
    // Arrange

    // Act
    $response = createService([
        'duration' => 'string',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'duration',
    ]);
});

test('field value must be a number', function () {
    // Arrange
    // Act
    $response = createService([
        'value' => 'value Number String',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'value',
    ]);
});
