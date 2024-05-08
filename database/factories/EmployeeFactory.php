<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->word,
            'photo' => null,
            'company_id' => 1,
        ];
    }
}
