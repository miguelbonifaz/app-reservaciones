<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Appointment::factory()->create([
//            'employee_id' => Employee::first()->id,
//            'service_id' => Service::first()->id,
//            'date' => today()->addDay(),
//            'start_time' => '12:00',
//        ]);
        $employee = Employee::factory()
            ->hasAttached(Service::factory())
            ->create();

        $employee->schedules->first()->update([
           'start_time' => '10:00',
           'end_time' => '18:00',
        ]);

        $employee->schedules->get(3)->update([
           'start_time' => '10:00',
           'end_time' => '18:00',
        ]);
    }
}
