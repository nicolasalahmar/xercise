<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            enrollSeeder::class,
            privateEnrollSeeder::class,
            workoutStatsSeeder::class,
            exerciseSeeder::class,
            exerciseProgramSeeder::class
        ]);
    }
}
