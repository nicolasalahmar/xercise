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
    public function activatePlan(Request $request){
        $user = Auth::user();
        if($request->has('program_id')){
            $user->active_program_id = $request->program_id;
            $user->active_private_program_id= null;
            $user->save();
            return response()->json(['success' => true,'message' => 'program activated.']);
        }
        else if($request->has('private_program_id')){
            $user->active_program_id = null;
            $user->active_private_program_id = $request->private_program_id;
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
            return response()->json( ['success'=>$req]);
        }
    }


    public function viewCustomPlans(){
        $user = Auth::user();
        $plans = private_program::query()->where('user_id', $user->user_id)->where('coach_id', NULL)->get('private_program_id');
        $arr = array();

        foreach($plans as $plan){
            $temp = private_program::where('private_program_id', $plan['private_program_id'])->first();
            //time per day and times a week must be added to programs table
            array_push($arr,$temp);
        }
        return response()->json($arr);
    }
    public function resetPlanProgress(Request $request){
        $user = Auth::user();
        if($request->has('program_id')){
           return response()->json(['message'=> workout_stats::query()->where('user_id',$user->user_id)->where('program_id',$request->program_id)->delete()]);
        }
        elseif($request->has('private_program_id')){
            return response()->json(['message'=> workout_stats::query()->where('user_id',$user->user_id)->where('private_program_id',$request->private_program_id)->delete()]);
        }
        else{
            return response()->json(['message'=>'no program_id or private_program_id provided']);
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
            }
            else
            {
                $firstName=$firstName['firstName'];
                $lastName=$lastName['lastName'];
                $temp['author']=$firstName.' '.$lastName;
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
            }
            else
            {
                $firstName=$firstName['firstName'];
                $lastName=$lastName['lastName'];
                $temp['author']=$firstName.' '.$lastName;
            }

            array_push($a2,$temp);
        }
        return response()->json(array_merge($a1,$a2));
    }

    //view active plan details on homescreen
    public function viewActivePlan(){
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
                $card['all_workout_days'][$i]['duration']=$t;
            }

        }

        if($user->active_private_program_id != NULL){

            //plan name
            $name = program::query()->where('private_program_id',$user->active_private_program_id)->pluck('name');
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
            $stats = workout_stats::query()->where('user_id',$user->user_id)->where('private_program_id',$user->active_private_program_id)->orderBy('created_at','desc')->get('day_num');
            $day = count($stats) + 1;
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
        }

        return $card;

    }


    public function currentWorkoutDetails(Request $request){
        $user = Auth::user();
        $details['day'] = 'Day '.$request->day;

        if($user->active_program_id != NULL){
            $exercises = exercise_program::query()->where('program_id',$user->active_program_id)->where('day_num',$request->day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $details['duration'] = array_sum($exercises);

            $details['workouts'] = count($exercises);

            $exercises_names = exercise_program::query()->where('program_id',$user->active_program_id)->where('day_num',$request->day)->get(['ex_id','reps','sets']);

            foreach($exercises_names as $ex){
               $temp =  exercise::query()->where('ex_id',$ex['ex_id'])->pluck('name');
               $ex['name'] = $temp[0];
            }
            $details['exercises'] = $exercises_names;
        }

        if($user->active_private_program_id != NULL){
            $exercises = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day_num',$request->day)->pluck('ex_id');
            for($i=0;$i<count($exercises);$i++){
               $temp =  exercise::query()->where('ex_id',$exercises[$i])->pluck('duration');
               $exercises[$i] = $temp[0];
            }
            $exercises = json_decode($exercises,true);
            $details['duration'] = array_sum($exercises);

            $details['workouts'] = count($exercises);

            $exercises_names = exercise_private_program::query()->where('private_program_id',$user->active_private_program_id)->where('day_num',$request->day)->get(['ex_id','reps','sets']);

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

        if($stats->save()){
            return response()->json(["success"=>true, "message"=>"Stats Saved Successfully"]);
        }else {
            return response()->json(["success"=>false, "message"=>"Error Saving Stats"]);
        }


    }

}
