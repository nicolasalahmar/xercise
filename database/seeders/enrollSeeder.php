<?php

namespace Database\Seeders;

use App\Models\user;
use App\Models\program;
use App\Models\enroll;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class enrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user::factory()->count(10)->create();
        program::factory()->count(10)->create();
        enroll::factory()->count(10)->create(['user_id'=>1]);
        enroll::factory()->count(5)->create(['program_id'=>3]);
        enroll::factory()->count(1)->create(['user_id'=>6,'program_id'=>6]);
    }
}
