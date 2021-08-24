<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numberBetween(00000000, 99999999),
        ];
    }

    public function configure(): EmployeeFactory
    {
        return $this->afterCreating(function (Employee $employee) {
            $locations = Location::all();

            foreach ($locations as $location) {
                collect(range(0, 6))->each(function ($number) use ($location, $employee) {
                    $employee->schedules()->create([
                        'day' => $number,
                        'employee_id' => $employee->id,
                        'location_id' => $location->id,
                    ]);
                });
            }
        });
    }
}
