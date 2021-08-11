<?php

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function deleteEmployee(Employee $employee)
{
    $url = route('employees.destroy', $employee);

    return test()->actingAsUser()->delete($url);
}

test('can delete a employee', function () {
    // Arrange
    $employee = Employee::factory()->create();

    //Act
    $response = deleteEmployee($employee);

    //Assert
    $response->assertRedirect(route('employees.index'));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito el empleado.');

    $this->assertEquals(0, Employee::count());
});
