<?php

namespace Database\Seeders;

use App\Models\workout_stats;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class workoutStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        workout_stats::factory()->count(5)->create(['program_id'=>2,'private_program_id'=>null,'user_id'=>1]);
        workout_stats::factory()->count(5)->create(['program_id'=>null,'private_program_id'=>3,'user_id'=>5]);
    }
}
