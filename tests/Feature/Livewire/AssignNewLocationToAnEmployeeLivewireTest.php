<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\AssignNewLocationToAnEmployeeLivewire;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildAssignNewLocationToAnEmployeeLivewireComponent(Employee $employee): TestableLivewire
{
    test()->actingAsUser();

    return livewire(AssignNewLocationToAnEmployeeLivewire::class, [
        'employeeId' => $employee->id,
    ]);
}

test('can create AssignNewLocationToAnEmployeeLivewire component', function () {
    // Arrange
    $employee = Employee::factory()->create();

    // Act
    $component = buildAssignNewLocationToAnEmployeeLivewireComponent($employee);

    // Assert
    expect($employee->id)->toBe($component->viewData('employeeId'));
    $this->assertNotNull($component);
});

test('can assign a new location to an employee', function () {
    // Arrange
    $employee = Employee::factory()->create();

    $newLocation = Location::factory()->create();

    expect($employee->locations)->toHaveCount(0);
    expect(Schedule::all())->toHaveCount(0);

    $component = buildAssignNewLocationToAnEmployeeLivewireComponent($employee);
    $component->set('locationId', $newLocation->id);

    // Act
    $component->call('assignLocation', $newLocation->id);

    // Assert
    $component->assertRedirect(route('employees.edit', $employee->id));

    expect($employee->fresh()->locations)->toHaveCount(1);

    expect($newLocation->id)->toBe($newLocation->id);
    expect(Schedule::all())->toHaveCount(7);
});
