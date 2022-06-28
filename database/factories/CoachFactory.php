<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\coach>
 */
class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);

        return [
            'FirstName' => $this->faker->firstName($gender),
            'LastName' => $this->faker->lastName($gender),
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$QT.snXcMwJJuOKNcS5EbW.PoTO1L8wfp11VuHk83zt10qD/XvuQ0q', // password
            'gender'=>$gender,
            'image'=>'coaches_1.jpg',
            'description'=>$this->faker->asciify('********************'),
            'rating'=>0,
            'phone'=>$this->faker->phoneNumber,
            'coach_num'=>'646464',
            'programs'=>0,
        ];
    }
}
