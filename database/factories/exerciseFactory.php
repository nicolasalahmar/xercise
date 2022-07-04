<?php

namespace Database\Factories;

use App\Models\exercises;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\exercise>
 */
class exerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ex_id' => $this->faker->numberBetween(0,188),
            'name' => $this->faker->name(),
            'knee' => $this->faker->randomElement(['Yes','No','A little']),
            'duration' => $this->faker->randomElement(['2.5','2']),
        ];
    }
}
