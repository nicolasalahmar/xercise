<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\constants;
use App\Models\user;
use App\Models\coach;
use App\Models\workout_stats;
use App\Models\body_stats;
use App\Models\rating_coach;
use App\Models\enroll;
use App\Models\private_enroll;
use App\Models\program;
use App\Models\private_program;
use App\Models\sleep_tracker;

use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;

class userController extends Controller
{

    public function saveImage($usr_id,$encodedImage){
        $path = constants::image_path;
        $imageName = 'users_'.($usr_id).'.jpg';
        $path = ($path).'users_'.($usr_id).'.jpg';
        $encodedImage = base64_decode($encodedImage);
        if(!gettype(file_put_contents(($path),$encodedImage)))
        {
            return false;
        }
        else {
                return true;
        }
    }


    public function showUserProfile(Request $request){
        $user = Auth::user(); //returns token's owner (user who owns the token)
        $user['type'] = "Trainee";
        return response()->json([$user]);
    }

    public function deleteUserAccount(Request $request){
        $user = Auth::user();
        return response()->json( ['success'=>$user->delete()]);
    }

    public function editUserProfile(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'FirstName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'LastName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'gender'=>['required','in:Male,Female'],
            'encodedImage'=>['min:5'],
            'DOB'=>['required','date'],
            'week_start'=>['required','in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'times_a_week'=>['required','in:1,2,3,4,5'],
            'time_per_day'=>['required','in:10,15,20,25,30,35,40'],
            'pushups'=>['required','in:1,2,3,4,5'],
            'plank'=>['required','in:1,2,3,4,5'],
            'knee'=>['required','in:Yes,No,A little'],
            'height'=>['required','numeric','gt:0'],
            'weight'=>['required','numeric','gt:0'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $user->FirstName = $request->FirstName;
        $user->LastName = $request->LastName;
        $user->gender = $request->gender;
        $user->DOB = $request->DOB;
        $user->height = $request->height;
        $user->height_new = $request->height;
        $user->weight = $request->weight;
        $user->week_start = $request->week_start;
        $user->times_a_week = $request->times_a_week;
        $user->time_per_day = $request->time_per_day;
        $user->pushups = $request->pushups;
        $user->plank = $request->plank;
        $user->knee = $request->knee;

        if($request->has('encodedImage'))
            $this->saveImage((string)$user->user_id,$request->encodedImage);

        if($user->save()){
            return response()->json(["success"=>true, "message"=>"info updated successfully!"]);
        }
        else {
            return response()->json(["success"=>false, "message"=>"Error editing profile."]);
        }

    }

    public function rateCoach(Request $request){
        $user = Auth::user();
        $coach_id = $request->coach_id;

        $validator = Validator::make($request->all(),[
            'rating'=>['required','in:1,2,3,4,5'],
            'coach_id'=>['required','exists:coaches,coach_id'],
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }

        if (rating_coach::query()->where('user_id',$user->user_id)->where('coach_id',$coach_id)->exists()){
            rating_coach::query()->where('user_id',$user->user_id)->where('coach_id',$coach_id)->update(['rating'=>$request->rating]);
        }
        else{
            $rate = new rating_coach();
            $rate->coach_id = $coach_id;
            $rate->user_id = $user->user_id;
            $rate->rating = $request->rating;

            if(!$rate->save()){
                return response()->json(["success"=>false, "message"=>"Error submitting rate."]);
            }
        }
        $sum=0.0;
        $new_rate = rating_coach::query()->select('rating')->where('coach_id',$coach_id)->get();
        foreach($new_rate as $single_rate){
            $sum +=(integer)$single_rate['rating'];
        }
        $avg = $sum/count($new_rate);
        $avg *=2;

        coach::query()->where('coach_id',$coach_id)->update(['rating'=>$avg]);

        return response()->json(["success"=>true, "message"=>"Rated coach successfully."]);
    }

    public function ratePlan(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'rating'=>['required','in:1,2,3,4,5'],
            'program_id'=>['required','exists:programs,program_id'],
        ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }

        $rating = $request->rating;
        $plan_id = $request->program_id;

        if (DB::table('rating_programs')->where('user_id',$user->user_id)->where('program_id',$plan_id)->exists()){
            return response()->json(['message'=>(boolean)DB::table('rating_programs')->where('user_id',$user->user_id)->where('program_id',$plan_id)->update(['rating'=>$request->rating])]);
        }
        else{
            return response()->json(['message'=>DB::table('rating_programs')->insert(['user_id'=>$user->user_id,'program_id'=>$plan_id,'rating'=>$rating])]);
        }
    }

    public function viewUserDashboard(){
        $users = user::query()->orderBy('duration','DESC')->limit(100)->get(['username','duration','image']);
        return response()->json($users);
    }

    public function viewCoachDashboard(){
        $coaches = coach::query()->orderBy('rating', 'DESC')->limit(100)->get(['FirstName','LastName','rating','image']);
        return response()->json($coaches);
    }

    public function enroll(Request $request){
        $user = Auth::user();
        $enroll = new enroll();
        $enroll->user_id = $user->user_id;
        $enroll->program_id = $request->program_id;
        $enroll->done = false;

        return response()->json(['message'=>$enroll->save()]);
    }

    public function resetAllProgress(){
        $user_id = Auth::user()->user_id;
        //delete all past exercising sessions
        workout_stats::query()->where('user_id',$user_id)->delete();

        //delete all sleep data
        sleep_tracker::query()->where('user_id',$user_id)->delete();

        //delete all steps taken
        $user = user::query()->where('user_id',$user_id)->first();
        $user->steps = 0;
        $user->step_update = date('Y-m-d');
        $user->save();

        return response()->json(['message'=>'deleted successfully']);
    }

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
            return response()->json( ['success'=>$req]);
        }
        if($request->has('private_program_id')){
            $req = private_enroll::query()->where('user_id', $user->user_id)->where('private_program_id',$request->private_program_id)->delete();
            return response()->json( ['success'=>$req]);
        }
        else{
            return response()->json( ['success'=>false,'message'=>'bad request'],400);
        }
    }


    public function viewCustomPlans(){
        $user = Auth::user();
        $plans = private_program::query()->where('user_id', $user->user_id)->where('coach_id', NULL)->get('private_program_id');
        $arr = array();

        foreach($plans as $plan){
            $temp = private_program::query()->where('private_program_id', $plan['private_program_id'])->first();
            //time per day and times a week must be added to programs table
            array_push($arr,$temp);
        }
        return response()->json($arr);
    }

    //step counter functions
    public function calculateSteps(Request $request){
        $user = Auth::user();
        $last_date = Carbon::parse($user->step_update)->format('y-m-d');
        $request_date = Carbon::now()->format('y-m-d');
        if($request_date > $last_date){
            $stored_steps = user::query()->where('user_id', $user->user_id)->first('steps');
            $old_steps = $stored_steps->steps;
            $new_steps = $request->steps;
            $user->steps = $old_steps + $new_steps;
            $user->step_update = date('y-m-d');
            return response()->json(['message'=>$user->save()]);
        }
        else{
            return response()->json(['message'=>'Only One Request Per Day']);
        }
    }

    public function resetSteps(){
        $user = Auth::user();
        $steps = user::query()->where('user_id', $user->user_id)->first();
        $steps->steps = 0;
        $steps->step_update = date('y-m-d');
        return response()->json(['message'=>$steps->save()]);
    }

    public function viewSteps(){
        $user = Auth::user();
        return response()->json(['total steps'=>$user->steps]);
    }

    public function viewSleep(){
        $user = Auth::user();
        $week = array();
        $week[0] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(7)->format('y-m-d'))->first();
        $week[1] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(6)->format('y-m-d'))->first();
        $week[2] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(5)->format('y-m-d'))->first();
        $week[3] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(4)->format('y-m-d'))->first();
        $week[4] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(3)->format('y-m-d'))->first();
        $week[5] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(2)->format('y-m-d'))->first();
        $week[6] = DB::table('sleep_trackers')->where('user_id',$user->user_id)->where('date',Carbon::now()->subDays(1)->format('y-m-d'))->first();

        return $week;
    }

    public function calculateSleep(Request $request){
        $user = Auth::user();

        $last_date = DB::table('sleep_trackers')->where('user_id',$user->user_id)->orderBy('date','DESC')->first();

        if($last_date == null){
            $result = DB::table('sleep_trackers')->insert(['hours'=>$request->hours,'date'=>date('y-m-d'),'user_id'=>$user->user_id]);
            return response()->json(['message'=>$result]);
        }
        else{
            $last_date = $last_date->date;
        }
        $last_date = Carbon::parse($last_date)->format('y-m-d');
        $request_date = Carbon::now()->format('y-m-d');

        if($request_date > $last_date){
            $result = DB::table('sleep_trackers')->insert(['hours'=>$request->hours,'date'=>date('y-m-d'),'user_id'=>$user->user_id]);
            return response()->json(['message'=>$result]);
        }
        else{
            return response()->json(['message'=>'Only One Request Per Day']);
        }
    }

    public function resetSleep(){
        $user = Auth::user();
        $result = DB::table('sleep_trackers')->where('user_id',$user->user_id)->delete();
        return response()->json(['message'=>(boolean)$result]);
    }

    public function searchCoach($search){
        $coach = DB::select('select coach_id,FirstName,LastName,rating,programs,image from coaches where CONCAT(FirstName ," ",LastName) like "%'.$search.'%" limit 10');
        return $coach;
    }

    public function searchPlan($search){
        $plans = DB::select('select * from programs where name like "%'.$search.'%" limit 10');
        return $plans;
    }

    public function search(Request $request){
        $search = $request->search;
        $coach = $this->searchCoach($search);
        $plans = $this->searchPlan($search);
        return response()->json(['coaches'=>$coach,'plans'=>$plans]);
    }

    public function discoverCoaches(){
        $coaches = coach::query()->orderBy('rating', 'DESC')->take(30)->get(['coach_id','FirstName','LastName','gender','rating','programs','image']);
        return response()->json($coaches);
    }

    public function viewCoachAndPlans(Request $request){
        $user = Auth::user();

        $coach['details'] = coach::query()->where('coach_id',$request->coach_id)->first(['coach_id','FirstName','LastName','gender','rating','programs','image','description','phone','email']);
        $coach['plans'] = program::query()->where('coach_id',$request->coach_id)->get();
        $coach['rating'] = rating_coach::query()->where('coach_id',$request->coach_id)->where('user_id',$user->user_id)->first();
        if($coach['rating'] != null){
            $coach['rating'] = (int)$coach['rating']['rating'];
        }
        return response()->json($coach);
    }

    public function addOtherDefaultPlan(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'name'=>['required','in:Muscle Fitness,Weight Loss,Height Increase,Stretching'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        //default plans have program_id of 1 2 3 4
        $default_enrolls = enroll::query()->where('user_id', $user->user_id)->whereIn('program_id',array(1,2,3,4))->pluck('program_id');

        foreach($default_enrolls as $enroll){
            $program_name = program::query()->where('program_id', $enroll)->pluck('name');
            foreach($program_name as $progn){
                if($request->name == $progn){
                    return response()->json(["success"=>false, "message"=>"Default Plan Already Exists"]);
                }
            }
        }

        $en = new enroll();
        $en->user_id = $user->user_id;
        $program_id = program::query()->where('coach_id',NULL)->where('name', $request->name)->pluck('program_id');
        foreach($program_id as $prog){
        $en->program_id = $prog;
        }

        if($en->save()){
            return response()->json(["success"=>true, "message"=>"Default Plan Added Successfully"]);
        }else {
            return response()->json(["success"=>false, "message"=>"Error Adding Default Plan"]);
        }
    }

    //statistics

    public function workoutStats(){
        $user = Auth::user();

        if($user->active_program_id != NULL){

            $dates = workout_stats::query()->where('user_id', $user->user_id)->where('program_id',$user->active_program_id)->pluck('created_at');
            for($i=0;$i<count($dates);$i++){
                $dates[$i] = $dates[$i]->format('y-m-d');
            }

            $stats['workout_dates'] = $dates;
            $stats['workouts'] = count($dates);

            $kcals = workout_stats::query()->where('user_id', $user->user_id)->where('program_id',$user->active_program_id)->pluck('kcal');
            $stats['kcal'] = array_sum(json_decode($kcals,true));

            $durations = workout_stats::query()->where('user_id', $user->user_id)->where('program_id',$user->active_program_id)->pluck('duration');
            $dur =  json_decode($durations,true); // to convert collection into array
            //helper function to calculate sum of durations and convert it into minutes
            $sum = strtotime('00:00:00');
            $sum2=0;
            foreach ($dur as $d){
                $sum1=strtotime($d)-$sum;
                $sum2 = $sum2+$sum1;
            }
            $sum3=$sum+$sum2;
            $time = date("H:i:s",$sum3);
            [$hours, $minutes] = explode(':', $time);

            $stats['duration'] = $hours * 60 + (int)$minutes;
            //---------------------------------------------
            return $stats;
        }

        if($user->active_private_program_id != NULL){

            $dates = workout_stats::query()->where('user_id', $user->user_id)->where('private_program_id',$user->active_private_program_id)->pluck('created_at');
            for($i=0;$i<count($dates);$i++){
                $dates[$i] = $dates[$i]->format('y-m-d');
            }

            $stats['workout_dates'] = $dates;
            $stats['workouts'] = count($dates);

            $kcals = workout_stats::query()->where('user_id', $user->user_id)->where('private_program_id',$user->active_private_program_id)->pluck('kcal');
            $stats['kcal'] = array_sum(json_decode($kcals,true));

            $durations = workout_stats::query()->where('user_id', $user->user_id)->where('private_program_id',$user->active_private_program_id)->pluck('duration');
            $dur =  json_decode($durations,true); // to convert collection into array
            //helper function to calculate sum of durations and convert it into minutes
            $sum = strtotime('00:00:00');
            $sum2=0;
            foreach ($dur as $d){
                $sum1=strtotime($d)-$sum;
                $sum2 = $sum2+$sum1;
            }
            $sum3=$sum+$sum2;
            $time = date("H:i:s",$sum3);
            [$hours, $minutes] = explode(':', $time);

            $stats['duration'] = $hours * 60 + (int)$minutes;

            //---------------------------------------------
            return $stats;
        }
    }

    public function saveWeight(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'date'=>['required','date','before:'.Carbon::now()->format('y-m-d')],
            'weight'=>['required','numeric','min:30'],
            ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }
        $date = $request->date;
        $user_id = $user->user_id;
        $temp = new body_stats();
        $temp->user_id = $user_id;
        $temp->weight = $request->weight;
        $temp->date = $date;
        if(body_stats::query()->where('date',$date)->where('user_id',$user_id)->exists()){
            body_stats::query()->where('date',$date)->where('user_id',$user_id)->update(['weight'=>$request->weight]);
        }
        else{
            $temp->save();
        }

        $latest_weight = body_stats::query()->where('user_id',$user->user_id)->orderBy('date','desc')->first();
        $user->weight = $latest_weight->weight;
        $user->save();

        return response()->json(["success"=>true, "message"=>"Body Stats Saved Successfully"]);
    }

    public function saveHeight(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'height'=>['required','numeric','min:100','gt:'.$user->height_new],
            ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }
        $height = $request->height;
        $user->height_new = $height;

        return response()->json(['success'=>$user->save()]);
    }

    public function bodyStats(){
        $user = Auth::user();
        $result['heights']['height_new'] = $user->height_new;
        $result['heights']['height'] = $user->height;

        $result['weight_graph'] = body_stats::query()->where('user_id',$user->user_id)->orderBy('date','desc')->get();  //this will return the weights in descending order
        $result['weights']['current_weight'] = $user->weight;

        $temp = clone($result['weight_graph']);
        for ($i=0;$i<count($temp);$i++){
            $temp[$i] = $result['weight_graph'][$i]['weight'];
        }
        $temp[$i] = $user->weight;

        $result['weights']['heaviest_weight'] = max(json_decode($temp,true));
        $result['weights']['lightest_weight'] = min(json_decode($temp,true));

        $weight = $user->weight;
        $height = $user->height_new;
        $bmi = $weight/($height/100*$height/100);

        if($bmi < 18.5)
            $status = "Underweight";
        else if($bmi >= 18.5 && $bmi <25 )
            $status = "Healthy";
        else if($bmi >= 25 && $bmi <30)
            $status = "Overweight";
        else{
            $status = "Obese";
        }

        $result['BMI']['BMI'] = $bmi;
        $result['BMI']['Body Status'] = $status;

        return $result;
    }

    public function statistics(){
        $result['workout_stats']=$this->workoutStats();
        $result['body_stats']=$this->bodyStats();
        $result['sleep_stats']=$this->viewSleep();
        return response()->json($result);
    }
}
