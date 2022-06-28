<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'username' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$QT.snXcMwJJuOKNcS5EbW.PoTO1L8wfp11VuHk83zt10qD/XvuQ0q', // password
            'gender'=>$gender,
            'image'=>'users_1.jpg',
            'DOB'=>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            'week_start'=>$this->faker->randomElement(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
            'times_a_week'=>$this->faker->randomElement(['1','2','3','4','5']),
            'time_per_day'=>$this->faker->randomElement(['10','15','20','25','30','35','40']),
            'initial_plan'=>$this->faker->randomElement(['muscle','weight','height','stretching']),
            'pushups'=>$this->faker->randomElement(['0-5','5-10','10-20','20-30','35+']),
            'plank'=>$this->faker->randomElement(['0-5','5-10','10-20','20-30','35+']),
            'knee'=>$this->faker->randomElement(['Yes','No','A little']),
            'height'=>$this->faker->numberBetween(120,200),
            'weight'=>$this->faker->numberBetween(50,100),
            'steps'=>$this->faker->numberBetween(1,20)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
