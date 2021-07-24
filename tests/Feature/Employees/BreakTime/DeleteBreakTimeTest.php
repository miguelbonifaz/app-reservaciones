<?php

use App\Models\RestSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can delete a break time', function () {
    // Arrange
    $breakTime = RestSchedule::factory()->create();

    $employee = $breakTime->schedule->employee;

    $url = route('employess.break-time.destroy', [$employee, $breakTime]);

    // Act
    $response = test()->actingAsUser()->get($url);

// Assert
    $response->assertRedirect(route('employees.edit', [$employee]));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito la hora de descanso.');

    $this->assertCount(0, RestSchedule::all());
});
