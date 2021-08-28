<?php

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can delete location from an employee', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->create();

    expect($employee->locations)->toHaveCount(1);
    expect(Schedule::all())->toHaveCount(7);

    $url = route('employees.locations.destroy', [$employee, $location]);

    //Act
    $response = test()->actingAsUser()->get($url);

    //Assert
    $response->assertRedirect(route('employees.edit', $employee));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito la localidad');

    expect($employee->fresh()->locations)->toHaveCount(0);
    expect(Schedule::all())->toHaveCount(0);
});
