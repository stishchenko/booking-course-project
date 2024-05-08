<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(rand(1, 3), true),
            'description' => $this->faker->sentence(3),
            'duration' => $this->faker->randomElement([30, 60]),
            'price' => $this->faker->numberBetween(100, 400),
        ];
    }
}
