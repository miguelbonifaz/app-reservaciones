<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function updateEmployee(Employee $employee ,$data = [])
{
    $url = route('employees.update' ,$employee);

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
    // Arrange
    $employee = Employee::factory()->create();

    $data = Employee::factory()->make();

    // Act
    $response = updateEmployee($employee,[
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
    ]);

    // Assert

    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el empleado.');

    $this->assertCount(1, Employee::all());

    $employee = Employee::first();

    $this->assertEquals($data->name, $employee->name);
    $this->assertEquals($data->email, $employee->email);
    $this->assertEquals($data->phone, $employee->phone);
});

test('can update an employee with the same email', function () {
    // Arrange
    $employee = Employee::factory()->create();

    $data = Employee::factory()->make();

    // Act
    $response = updateEmployee($employee,[
        'name' => $data->name,
        'email' => $employee->email,
        'phone' => $data->phone,
    ]);

    // Assert
    $response->assertSessionHasNoErrors('email');
});

test('fields are required', function () {
    // Arrange
    $employee = Employee::factory()->create();
    //Act
    $response = updateEmployee($employee,[
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

test('field phone must be a number', function () {
    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()->create();

    // Act
    $response = updateEmployee($employee,[
        'phone' => 'phone Number String',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'phone',
    ]);
});

test('field email must be unique', function () {
    // Arrange
    $anotherEmployee = Employee::factory()->create();

    $employee = Employee::factory()->create();

    // Act
    $response = updateEmployee($employee,[
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
    $employee = Employee::factory()->create();

    // Act
    $response = updateEmployee($employee,[
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
    $response = updateEmployee($employee,[
        'email' => $employee->email,
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});
