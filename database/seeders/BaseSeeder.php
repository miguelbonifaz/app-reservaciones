<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        $employee = Employee::factory()
            ->hasAttached(Location::factory()->count(2))
            ->hasAttached(Service::factory())
            ->create();

        $locationOne = $employee->locations->first();
        $locationTwo = $employee->locations->last();

        $locationOne->update([
            'name' => 'Urdesa Central'
        ]);

        $locationTwo->update([
            'name' => 'Samborondon'
        ]);

        $schedule = Schedule::where('location_id', $locationOne->id)
            ->where('day', 2)
            ->first();
        $schedule->update([
           'start_time' => '10:00',
           'end_time' => '15:00',
        ]);

        $schedule = Schedule::where('location_id', $locationTwo->id)
            ->where('day', 2)
            ->first();

        $schedule->update([
           'start_time' => '18:00',
           'end_time' => '21:00',
        ]);
    }
}
