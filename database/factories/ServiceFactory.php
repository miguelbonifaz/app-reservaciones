<?php

namespace Database\Factories;

use App\Models\Location;
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
        $duration = collect([30, 60, 120, 150])->random();

        return [
            'name' => $this->faker->name(),
            'duration' => $duration,
            'value' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->paragraph(6),
            'place' => config('mariajosejauregui.place-outside-the-office')->random(),
            'slots' => 1
        ];
    }
}
