<?php

namespace Database\Factories;

use App\Models\private_program;
use App\Models\program;

use App\Models\workout_stats;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class workoutStatsFactory extends Factory
{
    protected $model = workout_stats::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'duration'=>$this->faker->dateTimeBetween('00:20:00', '00:50:00'),
            'Kcal'=>$this->faker->numberBetween(0,5),
            'user_id'=>$this,
        ];
    }
}
