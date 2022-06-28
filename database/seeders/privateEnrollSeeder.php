<?php

namespace Database\Seeders;

use App\Models\user;

use App\Models\private_program;
use App\Models\private_enroll;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class privateEnrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        private_enroll::factory()->count(10)->create(['user_id'=>2]);
        private_enroll::factory()->count(5)->create(['private_program_id'=>4]);
        private_enroll::factory()->count(1)->create(['user_id'=>6,'private_program_id'=>6]);
    }
}
