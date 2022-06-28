<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\user;
use App\Models\private_enroll;
use App\Models\private_program;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=private_enroll>
 */
class privateEnrollFactory extends Factory
{
    protected $model = private_enroll::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>user::factory()->create()->user_id,
            'private_program_id'=>private_program::factory()->create()->private_program_id,
            'done'=>false,
        ];
    }
}
