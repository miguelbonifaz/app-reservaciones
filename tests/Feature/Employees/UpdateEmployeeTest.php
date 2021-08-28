<?php

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function updateEmployee(Employee $employee, $data = [])
{
    $url = route('employees.update', $employee);

    return test()->actingAsUser()->post($url, $data);
}

test('can see create employee form', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()->create();

    // Act
    $url = route('employees.edit', $employee);

    $response = $this->actingAsUser()->get($url);
    // Assert
    $response->assertOk();

    $response->assertViewIs('employees.edit');

    $response->assertViewHas('employee');
});

test('can update an employee', function () {
    $this->withoutExceptionHandling();
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    $data = Employee::factory()->make();

    // Act
    $response = updateEmployee($employee, [
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'servicesId' => [$service->id]
    ]);

    // Assert
    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el empleado.');

    $this->assertCount(1, Employee::all());

    $employee = Employee::first();

    $this->assertEquals($data->name, $employee->name);
    $this->assertEquals($data->email, $employee->email);
    $this->assertEquals($data->phone, $employee->phone);

    $this->assertCount(1, $employee->services);
    $this->assertEquals($service->id, $employee->services->first()->id);
});

test('can update an employee with the same email', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    $data = Employee::factory()->make();

    // Act
    $response = updateEmployee($employee, [
        'name' => $data->name,
        'email' => $employee->email,
        'phone' => $data->phone,
        'servicesId' => [$service->id],
        'locationsId' => [$location->id],
    ]);

    // Assert
    $response->assertSessionHasNoErrors('email');
});

test('fields are required', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    //Act
    $response = updateEmployee($employee, [
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

test('field servicesId are required', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    //Act
    $response = updateEmployee($employee);

    //Assert
    $response->assertSessionHasErrors([
        'servicesId',
    ]);
});

test('field phone must be a number', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    // Act
    $response = updateEmployee($employee, [
        'phone' => 'phone Number String',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'phone',
    ]);
});

test('field email must be unique', function () {
    // Arrange
    $anotherEmployee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    $employee = Employee::factory()->create();

    // Act
    $response = updateEmployee($employee, [
        'email' => $anotherEmployee->email,
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

test('field email must be valid', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create())
        ->hasAttached($location = Location::factory()->create())
        ->create();

    // Act
    $response = updateEmployee($employee, [
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

