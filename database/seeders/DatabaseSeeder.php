<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        User::factory()->create([
            'email' => 'demo@gmail.com',
            'password' => bcrypt('demo12345')
        ]);

        Customer::factory(5)->create();
        $services = Service::factory(3)->state(new Sequence(
            ['name' => 'Service 1'],
            ['name' => 'Service 2'],
            ['name' => 'Service 3']
        ))->create();

        $employee = Employee::factory()
            ->create();

        $employee->services()->attach($services->pluck('id'));

        collect([
            1 => [
                'start' => '08:00',
                'end' => '12:00',
            ],
            3 => [
                'start' => '10:00',
                'end' => '17:00',
            ],
            5 => [
                'start' => '15:00',
                'end' => '21:00',
            ],
        ])->each(function ($hour, $day) use ($employee) {
            $schedule = Schedule::query()
                ->where('employee_id', $employee->id)
                ->where('day', $day)
                ->first();

            $schedule->update([
                'start_time' => $hour['start'],
                'end_time' => $hour['end'],
            ]);
        });

    }
}
