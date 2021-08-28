<?php

namespace Tests\Feature\Employees\Locations;

use App\Models\Employee;
use App\Models\Location;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_schedule_list()
    {
        // Arrange
        $employee = Employee::factory()
            ->hasAttached($location = Location::factory()->create())
            ->create();

        $url = route('employees.locations.index', [$employee, $location]);

        // Act
        $response = $this->actingAsUser()->get($url);

        // Assert
        $response->assertOk();

        $response->assertViewIs('employees.locations.index');
    }
}
