<?php

namespace Database\Factories;

use App\Models\exercise_program;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class exerciseProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = exercise_program::class;
    public function definition()
    {

        return [
            'ex_id' => $this->faker->numberBetween(1, 10),
            'program_id' => $this->faker->numberBetween(1, 10),
            'day' => $this->faker->randomElement(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17'
            ,'18','19','20','21','22','23','24','25','26','27','28']),
            'reps' => $this->faker->numberBetween(1, 10),
            'sets' => $this->faker->numberBetween(1, 10),
        ];
    }
}
