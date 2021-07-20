<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $duration = collect([10, 20, 30, 40, 50, 60, 70,])->random();

        return [
            'name' => $this->faker->name(),
            'duration' => $duration,
        ];
    }
}
