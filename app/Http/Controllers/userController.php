<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\constants;
use App\Models\user;
use App\Models\coach;
use App\Models\rating_coach;
use App\Models\requests;
use App\Models\enroll;
use App\Models\private_enroll;
use App\Models\program;
use App\Models\private_program;

use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;

class userController extends Controller
{

    public function saveImage($usr_id,$encodedImage){
        $path = constants::image_path;
        $imageName = 'user_'.($usr_id).'.jpg';
        $path = ($path).'user_'.($usr_id).'.jpg';
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



        public function rateCoach(Request $request, $coach_id){
            $user = Auth::user();

            $validator = Validator::make($request->all(),[
                'rating'=>['required','in:1,2,3,4,5'],
            ]);

            if($validator->fails()){
                return $validator->errors()->all();
            }

            if (rating_coach::query()->where('user_id',$user->user_id)->where('coach_id',$coach_id)->exists()){
                rating_coach::where('user_id',$user->user_id)->where('coach_id',$coach_id)->update(['rating'=>$request->rating]);
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

            return response()->json(["success"=>true, "message"=>"Rated coach successfuly."]);
    }



        public function viewRequest(){  //in request details in frontend add coach name/time of creation/delete status
            $user = Auth::user(); //returns token's owner (user who owns the token)
            $id = request()->query('request_id');
            $req = requests::query()->where('request_id',$id)->first(); //delete second where
            $coach_firstname = coach::query()->where('coach_id',$req->coach_id)->first('FirstName');
            $coach_lastname = coach::query()->where('coach_id',$req->coach_id)->first('LastName');
            $req['coach_firstname'] = $coach_firstname['FirstName'];
            $req['coach_lastname'] = $coach_lastname['LastName'];
            return response()->json($req);
        }

        public function showCurrentRequests(){
            $user = Auth::user(); //returns token's owner (user who owns the token)
            $req = requests::query()->where('user_id',$user->user_id)->get(['name','status','created_at','coach_id']);

            foreach($req as $r){
                $coach_firstname = coach::query()->where('coach_id',$r->coach_id)->first('FirstName');
                $coach_lastname = coach::query()->where('coach_id',$r->coach_id)->first('LastName');
                $r['coach_firstname'] = $coach_firstname['FirstName'];
                $r['coach_lastname'] = $coach_lastname['LastName'];
            }
            return response()->json($req);
        }

        public function deleteRequest(){
            $user = Auth::user();
            $id = request()->query('request_id');
            $req = requests::query()->where('request_id',$id)->first();
            return response()->json( ['success'=>$req->delete()]);
        }

        public function viewUserDashboard(){
            $users = user::query()->orderBy('duration','DESC')->limit(100)->get(['username','duration','image']);
            return response()->json($users);
        }

        public function viewCoachDashboard(){
            $coaches = coach::query()->orderBy('rating', 'DESC')->limit(100)->get(['FirstName','LastName','rating','image']);
            return response()->json($coaches);
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
<<<<<<< HEAD
=======

>>>>>>> 783879425b717e3ac13382531b28aadf6b0da613
    }

}
