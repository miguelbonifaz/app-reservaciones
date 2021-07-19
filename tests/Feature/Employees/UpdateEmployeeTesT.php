<?php

use App\Http\Livewire\EmployeeRestScheduleLivewire;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

uses(DatabaseTransactions::class);

function updateEmployee(Employee $employee ,$data = [])
{
    $url = route('employees.update' ,$employee);

    return test()->actingAsUser()->post($url, $data);
}

function buildComponent($scheduleId = null)
{
    $this->actingAsUser();
    return Livewire::test(EmployeeRestScheduleLivewire::class, [
        'scheduleId' => $scheduleId,
    ]);
}

test('can make the component in the form', function () {

    // Arrange
    /** @var Employee $employee */
    $employee = Employee::factory()->create();
    $scheduleId = $employee->schedules->first()->id;
    // Act
    $component = $this->buildComponent($scheduleId);
    
    // Assert
    $this->assertNotNull($component);
});

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
    /** @var Employee $data */
    $service = Service::factory()->create();

    /* $linkActivity = factory(LinkActivity::class)->make(); */
    
    $employee = Employee::factory()->create();

    $scheduleId = $employee->schedules->first()->id;
    
    $data = Employee::factory()->make();    

    // Act
    $response = updateEmployee($employee,[
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'servicesId' => [$service->id],
        'start_time' => ['0' => '00:00'],
        'end_time' => ['0' => '02:00'],
    ]);

    $component = $this->buildComponent($scheduleId);

    $component->set('start_time', '12:00')
        ->set('end_time',  '18:00')
        ->call('storeRest');

    // Assert
    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el empleado.');

    $this->assertCount(1, Employee::all());

    $employee = Employee::first();    

    $this->assertEquals($data->name, $employee->name);
    $this->assertEquals($data->email, $employee->email);
    $this->assertEquals($data->phone, $employee->phone);
    $this->assertEquals('00:00:00', $employee->schedules->first()->start_time);
    $this->assertEquals('02:00:00', $employee->schedules->first()->end_time);

    $this->assertCount(1, $employee->services);
    $this->assertEquals($service->id, $employee->services->first()->id);

    $this->assertCount(7, Schedule::all());

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
