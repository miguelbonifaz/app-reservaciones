<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $startTime = today()->setTime(config('booking.factory.startTime')->random(), 0);

        $service = Service::factory()->withALocation()->create();

        return [
            'employee_id' => Employee::factory()->create(),
            'customer_id' => Customer::factory()->create(),
            'service_id' => $service->id,
            'location_id' => function ($data) {
                $service = Service::find($data['service_id']);
                return $service->locations()->first()->id;
            },
            'date' => today()->startOfWeek()->addDays(rand(0, 7)),
            'start_time' => $startTime,
            'note' => $this->faker->sentence,
        ];
    }
}
