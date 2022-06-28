<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=enroll>
 */
class enrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>user::factory()->create()->user_id,
            'program_id'=>program::factory(),
            'done'=>false,
        ];
    }
}
