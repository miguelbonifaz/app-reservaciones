<?php

namespace Tests\Feature\Employees\Locations;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateScheduleTest extends TestCase
{
    use RefreshDatabase;

    private function updateSchedule(Employee $employee, Location $location, $data = [])
    {
        $url = route('employees.locations.update', [$employee, $location]);

        return $this->actingAsUser()->post($url, $data);
    }

    /** @test */
    public function can_update_a_schedule()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $employee = Employee::factory()
            ->hasAttached($location = Location::factory()->create())
            ->create();

        // Act
        $response = $this->updateSchedule($employee, $location, [
            'start_time' => ['1' => '10:00'],
            'end_time' => ['1' => '15:00'],
        ]);

        // Assert
        $response->assertRedirect(route('employees.locations.index', [$employee, $location]));

        $response->assertSessionHas('flash_success', 'Se actualizó con éxito el horario');

        $schedules = Schedule::query()
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->get();

        $this->assertCount(1, $schedules);

        $schedule = $schedules->first();
        $this->assertEquals(
            '10:00',
            $schedule->start_time->format('H:i')
        );
        $this->assertEquals(
            '15:00',
            $schedule->end_time->format('H:i')
        );
    }
}
