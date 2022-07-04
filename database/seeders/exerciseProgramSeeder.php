<?php

namespace Database\Seeders;

use App\Models\exercise_program;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class exerciseProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<4;$i++){
            exercise_program::factory()->create(['ex_id'=>1,'program_id'=>2,'day'=>1+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>2,'program_id'=>2,'day'=>1+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>3,'program_id'=>2,'day'=>1+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>1,'program_id'=>2,'day'=>2+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>2,'program_id'=>2,'day'=>2+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>3,'program_id'=>2,'day'=>2+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>189,'program_id'=>2,'day'=>3+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>1,'program_id'=>2,'day'=>4+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>2,'program_id'=>2,'day'=>4+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>3,'program_id'=>2,'day'=>4+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>1,'program_id'=>2,'day'=>5+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>2,'program_id'=>2,'day'=>5+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>3,'program_id'=>2,'day'=>5+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>189,'program_id'=>2,'day'=>6+$i*7,'reps'=>'10','sets'=>'10']);
            exercise_program::factory()->create(['ex_id'=>189,'program_id'=>2,'day'=>7+$i*7,'reps'=>'10','sets'=>'10']);
        }
    }
}
