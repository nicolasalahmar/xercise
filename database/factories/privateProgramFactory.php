<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\coach;
use App\Models\user;
use App\Models\private_program;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=private_program>
 */
class privateProgramFactory extends Factory
{

    protected $model = private_program::class;

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
            'coach_id'=>coach::factory()->create()->coach_id,
            'duration'=>$this->faker->dateTimeBetween('00:20:00', '00:50:00'),
            'user_id'=>user::factory()->create()->user_id,
        ];
    }
}
