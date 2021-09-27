<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class BaseSeederForTesting extends Seeder
{
    use WithFaker;

    public function run()
    {
        $employee = Employee::factory()->create();

        $urdesa = Location::create(['name' => 'Urdesa']);

        $service = Service::factory()->create();

        $employee->services()->attach([$service->id]);

        $this->createLocation($employee, $urdesa);

        $start_time = [
            0 => '10:00',
            1 => '10:00',
            2 => '10:00',
            3 => '10:00',
            4 => '10:00',
            5 => '10:00',
            6 => '10:00',
        ];

        $end_time = [
            0 => '20:00',
            1 => '20:00',
            2 => '20:00',
            3 => '20:00',
            4 => '20:00',
            5 => '20:00',
            6 => '20:00',
        ];

        $this->createSchedule($start_time, $employee, $urdesa, $end_time);
    }

    public function createLocation($employee, $location): void
    {
        $days = collect([0, 1, 2, 3, 4, 5, 6]);

        $days->each(function ($day) use ($location, $employee) {
            $employee->schedules()->create([
                'day' => $day,
                'employee_id' => $employee->id,
                'location_id' => $location->id,
            ]);
        });

        $employee->locations()->attach([$location->id]);
    }

    public function createSchedule(array $start_time, $employee, $location, array $end_time): void
    {
        collect($start_time)->each(function ($hour, $day) use ($employee, $location) {
            $schedule = Schedule::query()
                ->where('day', $day)
                ->where('location_id', $location->id)
                ->where('employee_id', $employee->id)
                ->first();

            if ($hour == null) {
                $schedule->update([
                    'start_time' => null,
                ]);

                return null;
            }

            $schedule->update([
                'start_time' => $hour,
            ]);
        });

        collect($end_time)->each(function ($hour, $day) use ($employee, $location) {
            $schedule = Schedule::query()
                ->where('day', $day)
                ->where('location_id', $location->id)
                ->where('employee_id', $employee->id)
                ->first();

            if ($hour == null) {
                $schedule->update([
                    'end_time' => null,
                ]);

                return null;
            }

            $schedule->update([
                'end_time' => $hour,
            ]);
        });
    }
}
