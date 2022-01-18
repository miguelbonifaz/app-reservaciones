<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\RestSchedule;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RestSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $startTime = today()->setTime(range(10,20), 0);

        $employee = Employee::factory()->create();

        return [
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addHour(),
            'schedule_id' => $employee->schedules->random()->id,
        ];
    }
}
