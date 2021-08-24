<?php

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createEmployee($data = [])
{
    $url = route('employees.store');

    return test()->actingAsUser()->post($url, $data);
}

test('can see create employee form', function () {
    // Arrange

    // Act
    $url = route('employees.create');

    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('employees.create');

    $response->assertViewHas('employee');
});

test('can create a employee', function () {
    // Arrange
    /** @var Employee $data */
    $data = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->make();

    // Act
    $response = createEmployee([
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'servicesId' => [$service->id],
        'locationsId' => [$location->id],
    ]);

    // Assert
    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el empleado.');

    $this->assertCount(1, Employee::all());

    $employee = Employee::first();
    $this->assertEquals($data->name, $employee->name);
    $this->assertEquals($data->email, $employee->email);
    $this->assertEquals($data->phone, $employee->phone);

    $this->assertCount(1, $employee->services);
    $this->assertEquals($service->id, $employee->services->first()->id);

    $this->assertCount(1, $employee->locations);
    $this->assertEquals($location->id, $employee->locations->first()->id);

    $this->assertCount(7, Schedule::all());

    collect(range(0, 6))->each(function ($number) use ($employee) {
        $schedule = Schedule::query()
            ->where('day', $number)
            ->where('employee_id', $employee->id)
            ->first();

        $this->assertNotNull($schedule);
    });
});

test('fields are required', function () {
    // Arrange
    //Act
    $response = createEmployee([
        'name' => null,
        'email' => null,
        'phone' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'email',
        'phone',
    ]);
});

test('field servicesId is required', function () {
    // Arrange

    //Act
    $response = createEmployee([
        'servicesId' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'servicesId',
    ]);
});

test('field locationsId is required', function () {
    // Arrange

    //Act
    $response = createEmployee([
        'locationsId' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'locationsId',
    ]);
});

test('field phone must be a number', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()->create();

    // Act
    $response = createEmployee([
        'phone' => 'phone Number String',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'phone',
    ]);
});

test('field email must be valid', function () {
    // Arrange
    // Act
    $response = createEmployee([
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

test('email must be unique', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()->create();

    // Act
    $response = createEmployee([
        'email' => $employee->email,
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});
