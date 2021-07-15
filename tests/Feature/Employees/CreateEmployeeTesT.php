<?php

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

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
    $data = Employee::factory()->make();

    $service = Service::factory()->count(5)->create();    
    
    $days = [0,1,2,3,4];
    // Act
    $response = createEmployee([
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
    ]);

    $employee = Employee::first();        
    
    foreach ($days as $day) {
        Schedule::create([
            'day' => $day,
            'employee_id' => $employee->id,
        ]);
    }

    dd($employee->schedules);

    $employee->services()->attach($service);        


    
    

    // Assert

    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el empleado.');

    $this->assertCount(1, Employee::all());

    $employee = Employee::first();

    $this->assertEquals($data->name, $employee->name);
    $this->assertEquals($data->email, $employee->email);
    $this->assertEquals($data->phone, $employee->phone);
    
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
