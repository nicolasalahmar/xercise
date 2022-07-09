<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\constants;
use App\Models\user;
use App\Models\coach;
use App\Models\workout_stats;
use App\Models\rating_coach;
use App\Models\requests;
use App\Models\enroll;
use App\Models\private_enroll;
use App\Models\program;
use App\Models\private_program;
use App\Models\exercise_program;
use App\Models\exercise_private_program;
use App\Models\exercise;


use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;

class planController extends Controller
{
    public function activatePlan(Request $request){     //TODO maybe the user is not enrolled in the plan in the first place
        $user = Auth::user();
        if($request->has('program_id')){
            if(program::query()->where('program_id',$request->program_id)->exists())
                $user->active_program_id = $request->program_id;
            else
                return response()->json(['success'=>false,'message'=>"there is no program by this id."]);
            $user->active_private_program_id= null;
            $user->save();
            return response()->json(['success' => true,'message' => 'program activated.']);
        }
        else if($request->has('private_program_id')){
            $user->active_program_id = null;
            if(private_program::query()->where('private_program_id',$request->private_program_id)->exists())
                $user->active_private_program_id = $request->private_program_id;
            else
                return response()->json(['success'=>false,'message'=>"there is no program by this id."]);
            $user->save();
            return response()->json(['success' => true,'message' => 'private program activated.']);
        }
        else {
            return response()->json(['success' => false,'message' => 'No program id provided'], 400);
        }
    }

//to remove a plan from my plans in user
    public function deletePlan(Request $request){
        $user = Auth::user();
        if($request->has('program_id')){
            $req = enroll::query()->where('user_id', $user->user_id)->where('program_id',$request->program_id)->delete();
            return response()->json( ['success'=>(boolean)$req]);
        }
        if($request->has('private_program_id')){
            $req = private_enroll::query()->where('user_id', $user->user_id)->where('private_program_id',$request->private_program_id)->delete();
            return response()->json( ['success'=>(boolean)$req]);
        }
    }


    public function viewCustomPlans(){
        $user = Auth::user();
        $plans = private_program::query()->where('user_id', $user->user_id)->where('coach_id', NULL)->get('private_program_id');
        $arr = array();

        foreach($plans as $plan){
            $temp = private_program::where('private_program_id', $plan['private_program_id'])->first();
            $temp['duration'] = explode(':',$temp['duration']);
            $temp['duration'] = ($temp['duration'][0]*60) + ($temp['duration'][1]) + ($temp['duration'][2]/60);
            $temp['duration'] = ceil($temp['duration']);
            array_push($arr,$temp);
        }
        return response()->json($arr);
    }

    public function resetPlanProgress(Request $request){
        $user = Auth::user();
        if($request->has('program_id')){
           return response()->json(['success'=>true,'message'=> workout_stats::query()->where('user_id',$user->user_id)->where('program_id',$request->program_id)->delete()]);
        }
        elseif($request->has('private_program_id')){
            return response()->json(['success'=>true,'message'=> workout_stats::query()->where('user_id',$user->user_id)->where('private_program_id',$request->private_program_id)->delete()]);
        }
        else{
            return response()->json(['message'=>'no program_id or private_program_id provided'],400);
        }
    }

    public function viewUserPlans(){
        $user = Auth::user();

        $user_public_plans = enroll::query()->where('user_id', $user->user_id)->get('program_id');
        $user_private_plans = private_enroll::query()->where('user_id', $user->user_id)->get('private_program_id');

        $a1 = array();

        foreach($user_public_plans as $plan)
        {
            $temp = program::where('program_id', $plan['program_id'])->first();
            $firstName=coach::where('coach_id', $temp['coach_id'])->first('firstName');
            $lastName=coach::where('coach_id', $temp['coach_id'])->first('lastName');

            if($firstName == NULL)
            {
                $temp['author']='Xercise';
                $temp['type']='Default';
            }
            else
            {
                $firstName=$firstName['firstName'];
                $lastName=$lastName['lastName'];
                $temp['author']=$firstName.' '.$lastName;
                $temp['type']='By Coach';
            }

            array_push($a1,$temp);
        }
        $a2 = array();
        foreach($user_private_plans as $plan)
        {
            $temp = private_program::where('private_program_id', $plan['private_program_id'])->first();
            $firstName=coach::where('coach_id', $temp['coach_id'])->first('firstName');
            $lastName=coach::where('coach_id', $temp['coach_id'])->first('lastName');

            if($firstName == NULL)
            {
                $temp['author']='Custom Plan';
                $temp['type']='Custom';
            }
            else
            {
                $firstName=$firstName['firstName'];
                $lastName=$lastName['lastName'];
                $temp['author']=$firstName.' '.$lastName;
                $temp['type']='Requested from Coach';
            }

            array_push($a2,$temp);
        }
        return response()->json(array_merge($a1,$a2));
    }

    //view active plan details on homescreen
    public function viewActivePlan(){       //Hrayr should return workout stats even if the day is rest
        $user = Auth::user();
        //user_id
        $card['user_id'] = $user->user_id;
        //user first name
        $ufirst_name = user::query()->where('user_id',$user->user_id)->pluck('FirstName');
        $card['user'] = $ufirst_name[0];

        if($user->active_program_id != NULL){

            //plan name
            $name = program::query()->where('program_id',$user->active_program_id)->pluck('name');
            $card['plan_name'] = $name[0];
            //author
            $coach_id = program::query()->where('program_id',$user->active_program_id)->pluck('coach_id');
            if($coach_id[0] == NULL){
                $author = 'Xercise';
            }else{
                $first_name = coach::query()->where('coach_id',$coach_id[0])->pluck('FirstName');
                $last_name = coach::query()->where('coach_id',$coach_id[0])->pluck('LastName');
                $author = $first_name[0].' '.$last_name[0];
            }
            $card['plan_author'] = $author;

            //kcal
            $kcal = program::query()->where('program_id',$user->active_program_id)->pluck('Kcal');
            $card['plan_kcal'] = $kcal[0];

            //duration
            $duration = program::query()->where('program_id',$user->active_program_id)->pluck('duration');
                                            //helper function to convert duration into minutes only
            $sum = strtotime('00:00:00');
            $sum2=0;
            foreach ($duration as $d){
                $sum1=strtotime($d)-$sum;
                $sum2 = $sum2+$sum1;
            }
            $sum3=$sum+$sum2;
            $time = date("H:i:s",$sum3);
            [$hours, $minutes] = explode(':', $time);
            $card['plan_duration'] = $hours * 60 + (int)$minutes;

            //workout day

            $stats = workout_stats::query()->where('user_id',$user->user_id)->where('program_id',$user->active_program_id)->orderBy('created_at','desc')->first('day_num');
            if($stats == null){
                $day=1;
            }
            else{
                $day = $stats['day_num'] + 1;
            }

            $card['workout_day'] = $day;

            //workout duration
            $exercises = exercise_program::query()->where('program_id',$user->active_program_id)->where('day',$day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $card['workout_duration'] = array_sum($exercises);

            //plan progress
            $card['plan_progress'] = (int)($day*100/28).'%';

            //all workout days
            //$temp[i][duration]=
            $something = array();
            for($i=1;$i<=28;$i++){
                $t = exercise_program::query()->where('program_id',$user->active_program_id)->where('day',$i)->pluck('ex_id');
                for($j=0;$j<count($t);$j++){
                    $temp =  exercise::query()->where('ex_id',$t[$j])->pluck('duration');
                    $t[$j] = $temp[0];
                 }
                $t = json_decode($t,true);
                $t = array_sum($t);
                if(workout_stats::query()->where('user_id',$user->user_id)->where('program_id',$user->active_program_id)->where('day_num',$i)->exists()){
                    $card['all_workout_days'][$i]['done']=true;
                }
                else{
                    $card['all_workout_days'][$i]['done']=false;
                }
                $card['all_workout_days'][$i]['duration']=$t;
            }

        }

        if($user->active_private_program_id != NULL){

            //plan name
            $name = private_program::query()->where('private_program_id',$user->active_private_program_id)->pluck('name');
            $card['plan_name'] = $name[0];
            //author
            $coach_id = private_program::query()->where('private_program_id',$user->active_private_program_id)->pluck('coach_id');
            if($coach_id[0] == NULL){
                $author = 'Custom';
            }else{
                $first_name = coach::query()->where('coach_id',$coach_id[0])->pluck('FirstName');
                $last_name = coach::query()->where('coach_id',$coach_id[0])->pluck('LastName');
                $author = $first_name[0].' '.$last_name[0];
            }
            $card['plan_author'] = $author;

            //kcal
            $kcal = private_program::query()->where('private_program_id',$user->active_private_program_id)->pluck('Kcal');
            $card['plan_kcal'] = $kcal[0];

            //duration
            $duration = private_program::query()->where('private_program_id',$user->active_private_program_id)->pluck('duration');
                                            //helper function to convert duration into minutes only
            $sum = strtotime('00:00:00');
            $sum2=0;
            foreach ($duration as $d){
                $sum1=strtotime($d)-$sum;
                $sum2 = $sum2+$sum1;
            }
            $sum3=$sum+$sum2;
            $time = date("H:i:s",$sum3);
            [$hours, $minutes] = explode(':', $time);
            $card['plan_duration'] = $hours * 60 + (int)$minutes;

            //workout day
            $stats = workout_stats::query()->where('user_id',$user->user_id)->where('private_program_id',$user->active_private_program_id)->orderBy('created_at','desc')->first('day_num');
            if($stats == null){
                $day=1;
            }
            else{
                $day = $stats['day_num'] + 1;
            }
            $card['workout_day'] = $day;

            //workout duration
            $exercises = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day',$day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $card['workout_duration'] = array_sum($exercises);

            //plan progress
            $card['plan_progress'] = (int)($day*100/28).'%';

            //all workout days
            $something = array();
            for($i=1;$i<=28;$i++){
                $t = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day',$i)->pluck('ex_id');
                for($j=0;$j<count($t);$j++){
                    $temp =  exercise::query()->where('ex_id',$t[$j])->pluck('duration');
                    $t[$j] = $temp[0];
                 }
                $t = json_decode($t,true);
                $t = array_sum($t);
                if(workout_stats::query()->where('user_id',$user->user_id)->where('private_program_id',$user->active_private_program_id)->where('day_num',$i)->exists()){
                    $card['all_workout_days'][$i]['done']=true;
                }
                else{
                    $card['all_workout_days'][$i]['done']=false;
                }
                $card['all_workout_days'][$i]['duration']=$t;
            }
        }

        return $card;

    }


    public function currentWorkoutDetails(Request $request){
        //Note: the duration is mostly null in here because this is the duration put by the coach and it will mostly be reps and sets instead of duration
        $user = Auth::user();
        $details['day'] = 'Day '.$request->day;

        if($user->active_program_id != NULL){
            $exercises = exercise_program::query()->where('program_id',$user->active_program_id)->where('day',$request->day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $details['total duration'] = array_sum($exercises);

            $details['workouts'] = count($exercises);

            $exercises_names = exercise_program::query()->where('program_id',$user->active_program_id)->where('day',$request->day)->get(['ex_id','reps','sets','duration']);

            foreach($exercises_names as $ex){
               $temp =  exercise::query()->where('ex_id',$ex['ex_id'])->pluck('name');
               $ex['name'] = $temp[0];
            }
            $details['exercises'] = $exercises_names;
        }

        if($user->active_private_program_id != NULL){
            $exercises = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day',$request->day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $details['total duration'] = array_sum($exercises);

            $details['workouts'] = count($exercises);

            $exercises_names = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day',$request->day)->get(['ex_id','reps','sets','duration']);

            foreach($exercises_names as $ex){
               $temp =  exercise::query()->where('ex_id',$ex['ex_id'])->pluck('name');
               $ex['name'] = $temp[0];
            }
            $details['exercises'] = $exercises_names;
        }

        return response()->json($details);
    }


    public function saveWorkoutStats(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'duration'=>['required','date_format:H:i:s'],
            'kcal'=>['required','numeric'],
            'day_num'=>['required','numeric'],
            ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }

        $stats = new workout_stats();

        $stats->user_id = $user->user_id;
        $stats->program_id = $user->active_program_id;
        $stats->private_program_id = $user->active_private_program_id;
        $stats->duration = $request->duration;
        $stats->kcal = $request->kcal;
        $stats->day_num = $request->day_num;

        $duration = $this->sum_the_time($user->duration,$stats->duration);

        $user->duration = $duration;
        $user->save();

        if ($request->day_num == 28){
            if($user->active_program_id != NULL){
                enroll::query()->where('user_id',$user->user_id)->where('program_id',$user->active_program_id)->update(['done'=>true]);
            }
            elseif ($user->active_private_program_id != NULL){
                enroll::query()->where('user_id',$user->user_id)->where('private_program_id',$user->active_private_program_id)->update(['done'=>true]);
            }
        }

        if($stats->save()){
            return response()->json(["success"=>true, "message"=>"Stats Saved Successfully"]);
        }else {
            return response()->json(["success"=>false, "message"=>"Error Saving Stats"]);
        }

    }

    function sum_the_time($time1, $time2) {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time)
        {
          list($hour,$minute,$second) = explode(':', $time);
          $seconds += $hour*3600;
          $seconds += $minute*60;
          $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        if($seconds < 9)
        {
        $seconds = "0".$seconds;
        }
        if($minutes < 9)
        {
        $minutes = "0".$minutes;
        }
          if($hours < 9)
        {
        $hours = "0".$hours;
        }
        return "{$hours}:{$minutes}:{$seconds}";
    }

    public function createCustomPlan(Request $request){
        //TODO jsondecode is causing problems with http requests we may have to remove it when combining with hrayr
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'name'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'description'=>['required','min:3','max:50','regex:/^[a-zA-Z ]+$/'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}
        //creating plan in private program table
        $plan = new private_program();

        $plan->user_id = $user->user_id;
        $plan->coach_id = NULL;
        $plan->name = $request->name;
        $plan->description = $request->description;

        $plan->duration = '00:00:00';
        $plan->kcal = 0.0;

        $plan->save();


        $Kcal = 0;
        $duration = 0;

        //enrolling user to plan in private enrolls table
        $enroll = new private_enroll();
        $enroll->user_id = $plan->user_id;
        $enroll->private_program_id = $plan->private_program_id;

        $enroll->save();

        //filling plan with exercises for each day
        if($request->day1 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 1;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8;
            $ex3->day = 15;
            $ex4->day = 22;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day1 = $request->day1;
            $day1 = json_decode($day1,true);
            foreach($day1 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 1;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8;
                $ex3->day = 15;
                $ex4->day = 22;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day2 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 2;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+1;
            $ex3->day = 15+1;
            $ex4->day = 22+1;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day2 = $request->day2;
            $day2 = json_decode($day2,true);
            foreach($day2 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 2;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+1;
                $ex3->day = 15+1;
                $ex4->day = 22+1;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day3 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 3;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+2;
            $ex3->day = 15+2;
            $ex4->day = 22+2;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day3 = $request->day3;
            $day3 = json_decode($day3,true);
            foreach($day3 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 3;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+2;
                $ex3->day = 15+2;
                $ex4->day = 22+2;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day4 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 4;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+3;
            $ex3->day = 15+3;
            $ex4->day = 22+3;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day4 = $request->day4;
            $day4 = json_decode($day4,true);
            foreach($day4 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 4;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+3;
                $ex3->day = 15+3;
                $ex4->day = 22+3;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day5 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 5;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+4;
            $ex3->day = 15+4;
            $ex4->day = 22+4;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day5 = $request->day5;
            $day5 = json_decode($day5,true);
            foreach($day5 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 5;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+4;
                $ex3->day = 15+4;
                $ex4->day = 22+4;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day6 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 6;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+5;
            $ex3->day = 15+5;
            $ex4->day = 22+5;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day6 = $request->day6;
            $day6 = json_decode($day6,true);
            foreach($day6 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 6;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+5;
                $ex3->day = 15+5;
                $ex4->day = 22+5;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day7 == NULL){
            $ex1 = new exercise_private_program();
            $ex2 = new exercise_private_program();
            $ex3 = new exercise_private_program();
            $ex4 = new exercise_private_program();

            $ex1->day = 7;
            $ex1->private_program_id = $plan->private_program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+6;
            $ex3->day = 15+6;
            $ex4->day = 22+6;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day7 = $request->day7;
            $day7 = json_decode($day7,true);
            foreach($day7 as $day){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 7;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+6;
                $ex3->day = 15+6;
                $ex4->day = 22+6;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        $plan->duration = sprintf('%02d:%02d:%02d', ($duration/ 3600),($duration/ 60 % 60), $duration% 60);
        $plan->Kcal = $Kcal;
        $plan->save();

        return response()->json(['message'=>'done']);
    }

    public function createPlanCoach(Request $request){
        //TODO should we use the fact that we know the first day of the week to start the program
        //TODO jsondecode is causing problems with http requests we may have to remove it when combining with hrayr
        //TODO username should be capable of being null
        $coach = Auth::user();

        $validator = Validator::make($request->all(),[
            'name'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'description'=>['required','min:3','max:50','regex:/^[a-zA-Z ]+$/'],
            'knee'=>['required','in:Yes,No,A little'],
            'category'=>['required','in:muscle,weight,height,stretching'],
            'username'=>['exists:users,username'],
    	]);
        if($validator->fails()){
    		return $validator->errors()->all();
    	}
        //creating a public plan
        if($request->username == NULL){
            $plan = new program();

            $plan->coach_id = $coach->coach_id;
            $plan->name = $request->name;
            $plan->description = $request->description;
            $plan->rating = 0.0;
            $plan->knee = $request->knee;
            $plan->category = $request->category;
            $plan->duration = '00:00:00';
            $plan->kcal = 0.0;

            $plan->save();

            $duration = 0;
            $Kcal = 0;

        //filling plan with exercises for each day
        if($request->day1 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 1;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8;
            $ex3->day = 15;
            $ex4->day = 22;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day1 = $request->day1;
            $day1 = json_decode($day1,true);
            foreach($day1 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 1;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8;
                $ex3->day = 15;
                $ex4->day = 22;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day2 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 2;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+1;
            $ex3->day = 15+1;
            $ex4->day = 22+1;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day2 = $request->day2;
            $day2 = json_decode($day2,true);
            foreach($day2 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 2;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+1;
                $ex3->day = 15+1;
                $ex4->day = 22+1;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day3 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 3;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+2;
            $ex3->day = 15+2;
            $ex4->day = 22+2;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day3 = $request->day3;
            $day3 = json_decode($day3,true);
            foreach($day3 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 3;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+2;
                $ex3->day = 15+2;
                $ex4->day = 22+2;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day4 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 4;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+3;
            $ex3->day = 15+3;
            $ex4->day = 22+3;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day4 = $request->day4;
            $day4 = json_decode($day4,true);
            foreach($day4 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 4;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+3;
                $ex3->day = 15+3;
                $ex4->day = 22+3;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day5 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 5;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+4;
            $ex3->day = 15+4;
            $ex4->day = 22+4;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day5 = $request->day5;
            $day5 = json_decode($day5,true);
            foreach($day5 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 5;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+4;
                $ex3->day = 15+4;
                $ex4->day = 22+4;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day6 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 6;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+5;
            $ex3->day = 15+5;
            $ex4->day = 22+5;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day6 = $request->day6;
            $day6 = json_decode($day6,true);
            foreach($day6 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 6;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+5;
                $ex3->day = 15+5;
                $ex4->day = 22+5;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        if($request->day7 == NULL){
            $ex1 = new exercise_program();
            $ex2 = new exercise_program();
            $ex3 = new exercise_program();
            $ex4 = new exercise_program();

            $ex1->day = 7;
            $ex1->program_id = $plan->program_id;
            $ex1->ex_id = 189;
            $ex1->reps = 0;
            $ex1->sets = 0;
            $ex1->duration = '00:00:00';

            $ex2 = $ex1;
            $ex3 = $ex1;
            $ex4 = $ex1;

            $ex2 = clone $ex1;
            $ex3 = clone $ex1;
            $ex4 = clone $ex1;

            $ex2->day = 8+6;
            $ex3->day = 15+6;
            $ex4->day = 22+6;

            $ex1->save();
            $ex2->save();
            $ex3->save();
            $ex4->save();
        }else{
            $day7 = $request->day7;
            $day7 = json_decode($day7,true);
            foreach($day7 as $day){
                $ex1 = new exercise_program();
                $ex2 = new exercise_program();
                $ex3 = new exercise_program();
                $ex4 = new exercise_program();

                $ex1->day = 7;
                $ex1->program_id = $plan->program_id;
                $ex1->ex_id = $day[0];
                $ex1->reps = $day[1];
                $ex1->sets = $day[2];
                $ex1->duration = $day[3];

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+6;
                $ex3->day = 15+6;
                $ex4->day = 22+6;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();

                $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
            }
        }

        //insret calculated kcal and duration here for public program
        $plan->duration = sprintf('%02d:%02d:%02d', ($duration/ 3600),($duration/ 60 % 60), $duration% 60);
        $plan->Kcal = $Kcal;
        $plan->save();

        return response()->json(['message'=>'done']);
        }




        if($request->username !=NULL ){


            $user_id = user::query()->where('username', $request->username)->pluck('user_id');
            $requested = requests::query()->where('user_id',$user_id[0])->where('coach_id',$coach->coach_id)->get();

            if(count($requested)>0){

            $plan = new private_program();
            $plan->user_id = $user_id[0];
            $plan->coach_id = $coach->coach_id;
            $plan->name = $request->name;
            $plan->description = $request->description;

            $plan->duration = '00:00:00';
            $plan->kcal = 0.0;

            $plan->save();

            $duration = 0;
            $Kcal = 0;

            //enrolling user to plan in private enrolls table
            $enroll = new private_enroll();
            $enroll->user_id = $plan->user_id;
            $enroll->private_program_id = $plan->private_program_id;

            $enroll->save();

            //filling plan with exercises for each day
            if($request->day1 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 1;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8;
                $ex3->day = 15;
                $ex4->day = 22;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                //TODO jsondecode is causing problems with http requests we may have to remove it when combining with hrayr
                $day1 = $request->day1;
                $day1 = json_decode($day1,true);
                foreach($day1 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 1;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8;
                    $ex3->day = 15;
                    $ex4->day = 22;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day2 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 2;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+1;
                $ex3->day = 15+1;
                $ex4->day = 22+1;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day2 = $request->day2;
                $day2 = json_decode($day2,true);
                foreach($day2 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 2;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+1;
                    $ex3->day = 15+1;
                    $ex4->day = 22+1;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day3 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 3;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+2;
                $ex3->day = 15+2;
                $ex4->day = 22+2;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day3 = $request->day3;
                $day3 = json_decode($day3,true);
                foreach($day3 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 3;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+2;
                    $ex3->day = 15+2;
                    $ex4->day = 22+2;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day4 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 4;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+3;
                $ex3->day = 15+3;
                $ex4->day = 22+3;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day4 = $request->day4;
                $day4 = json_decode($day4,true);
                foreach($day4 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 4;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+3;
                    $ex3->day = 15+3;
                    $ex4->day = 22+3;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day5 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 5;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+4;
                $ex3->day = 15+4;
                $ex4->day = 22+4;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day5 = $request->day5;
                $day5 = json_decode($day5,true);
                foreach($day5 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 5;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+4;
                    $ex3->day = 15+4;
                    $ex4->day = 22+4;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day6 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 6;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+5;
                $ex3->day = 15+5;
                $ex4->day = 22+5;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day6 = $request->day6;
                $day6 = json_decode($day6,true);
                foreach($day6 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 6;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+5;
                    $ex3->day = 15+5;
                    $ex4->day = 22+5;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }

            if($request->day7 == NULL){
                $ex1 = new exercise_private_program();
                $ex2 = new exercise_private_program();
                $ex3 = new exercise_private_program();
                $ex4 = new exercise_private_program();

                $ex1->day = 7;
                $ex1->private_program_id = $plan->private_program_id;
                $ex1->ex_id = 189;
                $ex1->reps = 0;
                $ex1->sets = 0;
                $ex1->duration = '00:00:00';

                $ex2 = $ex1;
                $ex3 = $ex1;
                $ex4 = $ex1;

                $ex2 = clone $ex1;
                $ex3 = clone $ex1;
                $ex4 = clone $ex1;

                $ex2->day = 8+6;
                $ex3->day = 15+6;
                $ex4->day = 22+6;

                $ex1->save();
                $ex2->save();
                $ex3->save();
                $ex4->save();
            }else{
                $day7 = $request->day7;
                $day7 = json_decode($day7,true);
                foreach($day7 as $day){
                    $ex1 = new exercise_private_program();
                    $ex2 = new exercise_private_program();
                    $ex3 = new exercise_private_program();
                    $ex4 = new exercise_private_program();

                    $ex1->day = 7;
                    $ex1->private_program_id = $plan->private_program_id;
                    $ex1->ex_id = $day[0];
                    $ex1->reps = $day[1];
                    $ex1->sets = $day[2];
                    $ex1->duration = $day[3];

                    $ex2 = clone $ex1;
                    $ex3 = clone $ex1;
                    $ex4 = clone $ex1;

                    $ex2->day = 8+6;
                    $ex3->day = 15+6;
                    $ex4->day = 22+6;

                    $ex1->save();
                    $ex2->save();
                    $ex3->save();
                    $ex4->save();

                    $Kcal += (exercise::query()->where('ex_id',$day[0])->pluck('kcal')[0]*4*$ex1->sets*$ex1->reps);
                    $duration += (exercise::query()->where('ex_id',$day[0])->pluck('duration')[0]*240*$ex1->sets);
                }
            }
            //insert kcal and duration calculation of private program here
            $plan->duration = sprintf('%02d:%02d:%02d', ($duration/ 3600),($duration/ 60 % 60), $duration% 60);
            $plan->Kcal = $Kcal;
            $plan->save();

            $req = requests::query()->where('user_id',$plan->user_id)->where('coach_id',$coach->coach_id)->update(['status'=>'accepted']);

            return response()->json(['message'=>'done']);
        }else{
            return response()->json(['message'=>'this user did not request a plan']);
        }

        }

    }

    public function defaultPlanPicker($category,$user){
        $difficulty = $this->userDifficulty($user->plank,$user->pushups);
        $times_a_week = $user->times_a_week;
        $time_per_day = $user->time_per_day;
        $time_per_day = ($time_per_day - 10)/5 + 1;
        $category = $this->category($category);

        $c = ($category-1)*105;
        $d = ($difficulty-1)*35;
        $w = ($times_a_week-1)*7;
        $t = $time_per_day;

        $result = $c + $d + $w + $t;
        return $result;
    }

    public function userDifficulty($plank,$pushups){
        $array=array('0-5'=>1,'5-10'=>2,'10-20'=>3,'20-30'=>4,'35+'=>5);

        if(!in_array($plank,array(1,2,3,4,5)))
            $plank = $array[$plank];

        if(!in_array($pushups,array(1,2,3,4,5)))
            $pushups = $array[$pushups];

        $avg = $average = array_sum(array($pushups,$plank))/2;
        $avg = floor($avg);
        if($avg == 1){
            $avg = 1;
        }
        if($avg == 2){
            $avg = 2;
        }
        if($avg == 3){
            $avg = 2;
        }
        if($avg == 4){
            $avg = 3;
        }
        if($avg == 5){
            $avg = 3;
        }
        return $avg;
    }

    public function enrollInDefaultPlan($category,$user){
        $enroll = new enroll();
        $user_id=$user->user_id;
        $enroll->user_id = $user_id;
        $program_id = $this->defaultPlanPicker($category,$user);
        $enroll->program_id = $program_id;

        if(enroll::query()->where('program_id',$program_id)->where('user_id',$user_id)->exists()){
            return response()->json(['success'=>false,'message'=>'user is already enrolled in this plan.']);
        }
        else{
            return response()->json(['success'=>$enroll->save()]);
        }
    }

    public function addDefaultPlan(Request $request){
        $user = Auth::user();
        return $this->enrollInDefaultPlan($request->category,$user);
    }

    public function category($category){
        $category = strtolower($category);
        $array=array('muscle fitness'=>1,'weight loss'=>2,'height increase'=>3,'stretching'=>4);
        return $array[$category];
    }
}
