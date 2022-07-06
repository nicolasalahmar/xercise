<?php

namespace Database\Seeders;

use App\Models\user;
use App\Models\program;
use App\Models\enroll;
use App\Models\exercise;
use App\Models\exercise_program;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class enrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public array $array=array(
    'Muscle Fitness'=>array(array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8)),
    'Weight Loss'=>array(array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8)),
    'Height Increase'=>array(array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8)),
    'Stretching'=>array(array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8),array(1,2,3,4,5,6,7,8))
    );
    public function run()
    {
        user::factory()->count(10)->create();


        foreach(array(8,10,12) as $difficulty){
            $category = 'Muscle Fitness';

            for($j=1;$j<=5;$j++){
                foreach(array('10','15','20','25','30','35','40') as $time_per_day) {
                    $program = program::factory()->create(['name'=>'Muscle Fitness','coach_id'=>null,'knee'=>'No','category'=>'muscle','Kcal'=>0,'duration'=>0]);
                    $program_id = $program->program_id;
                    $arr = $this->createProgramTimesAweek($time_per_day,$j, $category, $program_id, $difficulty);
                    $program->Kcal = $arr['Kcal'];
                    $program->duration = $arr['duration'];
                    $program->save();
                }
            }
        }
        foreach(array(8,10,12) as $difficulty){
            $category = 'Weight Loss';

            for($j=1;$j<=5;$j++){
                foreach(array('10','15','20','25','30','35','40') as $time_per_day) {
                    $program = program::factory()->create(['name'=>'Weight Loss','coach_id'=>null,'knee'=>'No','category'=>'weight','Kcal'=>0,'duration'=>0]);
                    $program_id = $program->program_id;
                    $arr = $this->createProgramTimesAweek($time_per_day,$j, $category, $program_id, $difficulty);
                    $program->Kcal = $arr['Kcal'];
                    $program->duration = $arr['duration'];
                    $program->save();
                }
            }
        }
        foreach(array(8,10,12) as $difficulty){
            $category = 'Height Increase';

            for($j=1;$j<=5;$j++){
                foreach(array('10','15','20','25','30','35','40') as $time_per_day) {
                    $program = program::factory()->create(['name'=>'Height Increase','coach_id'=>null,'knee'=>'No','category'=>'height','Kcal'=>0,'duration'=>0]);
                    $program_id = $program->program_id;
                    $arr = $this->createProgramTimesAweek($time_per_day,$j, $category, $program_id, $difficulty);
                    $program->Kcal = $arr['Kcal'];
                    $program->duration = $arr['duration'];
                    $program->save();
                }
            }
        }
        foreach(array(8,10,12) as $difficulty){
            $category = 'Stretching';

            for($j=1;$j<=5;$j++){
                foreach(array('10','15','20','25','30','35','40') as $time_per_day){
                    $program = program::factory()->create(['name'=>'Stretching','coach_id'=>null,'knee'=>'No','category'=>'stretching','Kcal'=>0,'duration'=>0]);
                    $program_id = $program->program_id;
                    $arr = $this->createProgramTimesAweek($time_per_day,$j,$category,$program_id,$difficulty);
                    $program->Kcal = $arr['Kcal'];
                    $program->duration = $arr['duration'];
                    $program->save();
                }
            }
        }

        program::factory()->count(10)->create();
        enroll::factory()->count(10)->create(['user_id'=>1]);
        enroll::factory()->count(1)->create(['user_id'=>6,'program_id'=>6]);
    }

    public function createProgramTimesAweek($time_per_day,$times_a_week,$category,$program_id,$difficulty){
        if($times_a_week==1){
            $array[0]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,1,false);
            $array[1]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,2,true);
            $array[2]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,3,true);
            $array[3]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,4,true);
            $array[4]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,5,true);
            $array[5]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,6,true);
            $array[6]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,7,true);
        }
        else if($times_a_week==2){
            $array[0]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,1,false);
            $array[1]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,2,true);
            $array[2]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,3,false);
            $array[3]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,4,true);
            $array[4]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,5,true);
            $array[5]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,6,true);
            $array[6]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,7,true);
        }
        else if($times_a_week==3){
            $array[0]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,1,false);
            $array[1]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,2,true);
            $array[2]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,3,false);
            $array[3]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,4,true);
            $array[4]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,5,false);
            $array[5]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,6,true);
            $array[6]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,7,true);
        }
        else if($times_a_week==4){
            $array[0]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,1,false);
            $array[1]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,2,true);
            $array[2]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,3,false);
            $array[3]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,4,true);
            $array[4]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,5,false);
            $array[5]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,6,true);
            $array[6]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,7,false);
        }
        else if($times_a_week==5){
            $array[0]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,1,false);
            $array[1]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,2,false);
            $array[2]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,3,false);
            $array[3]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,4,true);
            $array[4]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,5,false);
            $array[5]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,6,true);
            $array[6]=$this->createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,7,false);
        }
        $Kcal = 0;
        $duration = 0;
        for($i=0;$i<7;$i++){
            $Kcal +=$array[$i]['Kcal'];
            $duration +=$array[$i]['duration'];
        }
        $duration = sprintf('%02d:%02d:%02d', ($duration/ 3600),($duration/ 60 % 60), $duration% 60);
        return array('Kcal'=>$Kcal,'duration'=>$duration);
    }

    public function createProgramTimePerDay($time_per_day,$category,$program_id,$difficulty,$day,$rest){
        if($rest){
            $this->addAnExercise(189,$program_id,$day,0,0);
            return array('Kcal'=>0,'duration'=>0);
        }
        else{
            //add one exercise which is 5 minutes
            $arr = array('Kcal'=>0,'duration'=>0);

            $temp = $this->addAnExercise($this->array[$category][$day-1][0],$program_id,$day,$difficulty,2);
            $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
            $arr['duration'] = $arr['duration'] + $temp['duration'];

            if($time_per_day == '10'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '15'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '20'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][3],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '25'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][3],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][4],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '30'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][3],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][4],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][5],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '35'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][3],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][4],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][5],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][6],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            elseif($time_per_day == '40'){
                $temp = $this->addAnExercise($this->array[$category][$day-1][1],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][2],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][3],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][4],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][5],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][6],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];

                $temp = $this->addAnExercise($this->array[$category][$day-1][7],$program_id,$day,$difficulty,2);
                $arr['Kcal'] = $arr['Kcal'] + $temp['Kcal'];
                $arr['duration'] = $arr['duration'] + $temp['duration'];
            }
            return $arr;
        }
    }

    public function addAnExercise($ex_id,$program_id,$day,$reps,$sets){
        exercise_program::factory()->create(['ex_id'=>$ex_id,'program_id'=>$program_id,'day'=>$day,'reps'=>$reps,'sets'=>$sets]);
        exercise_program::factory()->create(['ex_id'=>$ex_id,'program_id'=>$program_id,'day'=>$day+7,'reps'=>$reps,'sets'=>$sets]);
        exercise_program::factory()->create(['ex_id'=>$ex_id,'program_id'=>$program_id,'day'=>$day+14,'reps'=>$reps,'sets'=>$sets]);
        exercise_program::factory()->create(['ex_id'=>$ex_id,'program_id'=>$program_id,'day'=>$day+21,'reps'=>$reps,'sets'=>$sets]);
        $temp = exercise::query()->where('ex_id',$ex_id)->first(['duration','Kcal']);
        return array('Kcal'=>$temp['Kcal']*4*$sets*$reps,'duration'=>$temp['duration']*240*$sets);
    }
}
