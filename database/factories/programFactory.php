<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\coach;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=program>
 */
class programFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description'=>$this->faker->asciify('********************'),
            'rating'=>0,
            'coach_id'=>coach::factory()->create()->coach_id,
            'knee'=>$this->faker->randomElement(['Yes'  , 'No','A Little']),
            'duration'=>$this->faker->dateTimeBetween('00:20:00', '00:50:00'),
            'category'=>$this->faker->randomElement(['muscle','weight','height','stretching']),
        ];
    }
}
