<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use App\Models\coach;
use Illuminate\Auth\AuthenticationException;

use Auth;
use Storage;
use DB;
use DateTime;

class AuthController extends Controller
{
    public function saveImage($usr_id,$encodedImage,$type){

        $imageName = $type.'_'.($usr_id).'.jpg';
        $imagePath = 'D:/Laravel Projects/Xercise/storage/app/Images/'.$type.'_'.($usr_id).'.jpg';
        $encodedImage = base64_decode($encodedImage);
        if(!gettype(file_put_contents($imagePath,$encodedImage)))
        {
            return false;
        }
        else {
            if($type == "users"){
                DB::table($type)->where('user_id',$usr_id)->update(['image'=>$imageName]);
                return true;
        }
        if($type == "coaches"){
            DB::table($type)->where('coach_id',$usr_id)->update(['image'=>$imageName]);
            return true;
    }
        }
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(),[
            'FirstName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'LastName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'username'=>['required','min:3','unique:users','unique:coaches','regex:/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/'],
            'email'=>['required','email:rfc,dns','unique:users','unique:coaches',],
            'password'=>['required','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'gender'=>['required','in:Male,Female'],
            'encodedImage'=>['min:5'],
            'DOB'=>['required','date'],
            'initial_plan'=>['required','in:muscle,weight,height,stretching'],
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

        $FirstName=$request->FirstName;
        $LastName=$request->LastName;
        $email=$request->email;
        $gender=$request->gender;
        $username = $request->username;
        $request['password']=Hash::make($request['password']);
        $password=$request->password;
        $DOB = $request->DOB;
        $height = $request->height;
        $weight = $request->weight;
        $initial_plan = $request->initial_plan;
        $times_a_week = $request->times_a_week;
        $time_per_day = $request->time_per_day;
        $pushups = $request->pushups;
        $plank = $request->plank;
        $knee = $request->knee;
        $week_start = $request->week_start;

        $user = user::query()->create([
            'FirstName'=>$FirstName,
            'LastName'=>$LastName,
        	'email'=>$email,
        	'password'=>$password,
            'gender'=>$gender,
            'username'=>$username,
            'image'=>null,
        	'DOB'=>$DOB,
            'height'=>$height,
            'weight'=>$weight,
            'initial_plan'=>$initial_plan,
            'times_a_week'=>$times_a_week,
            'time_per_day'=>$time_per_day,
            'pushups'=>$pushups,
            'plank'=>$plank,
            'knee'=>$knee,
            'week_start'=>$week_start,
            'active_program'=>null,
        ]);
        if($user->user_id){
            if($request->has('encodedImage'))
                $this->saveImage((string)$user->user_id,$request->encodedImage,'users');
            return response()->json(['success'=>true,'message'=>'User created successfully']); //NOTE: image is true when image is uploaded or when there is no image
        }
        else {
            return response()->json(['success'=>false,'message'=>"User wasn't created successfully"]); //NOTE: image is true when image is uploaded or when there is no image
        }
    }

    public function createCoach(Request $request){
        $validator = Validator::make($request->all(),[
            'FirstName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'LastName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'username'=>['required','min:3','unique:coaches','unique:users','regex:/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/'],
            'email'=>['required','email:rfc,dns','unique:coaches','unique:users',],
            'password'=>['required','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'gender'=>['required','in:Male,Female'],
            'encodedImage'=>['min:5'],
    		'description'=>['required'],
            'coach_num'=>['required','min:6','max:6'],
            'phone'=>['required','min:10','max:10'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $FirstName=$request->FirstName;
        $LastName=$request->LastName;
        $email=$request->email;
        $gender=$request->gender;
        $username = $request->username;
        $request['password']=Hash::make($request['password']);
        $password=$request->password;
        $description = $request->description;
        $coach_num = $request->coach_num;
        $phone = $request->phone;

        $contents = json_decode(Storage::get('coaches.json'),true);

        //return $contents;
        if (!isset( $contents[$coach_num])){
            return response()->json(['success'=>false,'errors'=>"coach id not found"],400);
        }
        else if ($contents[$coach_num]['active']){
            return response()->json(['success'=>false,'errors'=>"coach id already taken and active"],400);
        }

        $contents[$coach_num]['active']=true; //set coach to active
        Storage::disk('local')->put('coaches.json', json_encode($contents));

        $coach = coach::query()->create([
            'FirstName'=>$FirstName,
            'LastName'=>$LastName,
        	'email'=>$email,
        	'password'=>$password,
            'gender'=>$gender,
            'username'=>$username,
            'image'=>null,
        	'description'=>$description,
            'coach_num'=>$coach_num,
            'phone'=>$phone,
            'rating'=>0,
        ]);

        if($coach->coach_id){
            if($request->has('encodedImage'))
                $this->saveImage((string)$coach->coach_id,$request->encodedImage,"coaches");
            return response()->json(['success'=>true,'message'=>'coach created successfully']);
        }
        else {
            return response()->json(['success'=>false,'message'=>"coach wasn't created successfully"]);
        }

    }

    public function logOut(){
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success'=>true,'message'=>'Logged out successfully.']);
    }

    public function splashScreen(Request $request){
        return response()->json(['success'=>true]);
    }

    public function coachLogin(Request $request)
    {
        if(!str_contains((string)$request->email,'@')){
            $b = coach::query()->where('username',request('email'))->get('email');
            if($b->isEmpty()){
                $success['email_correct'] = false;
                $success['success'] = false;
                return $success;
            }
            else{
                $request->email = $b[0]['email'];
            }
        }


        if(auth()->guard('coach')->attempt(['email' => $request->email, 'password' => $request->password])){

            config(['auth.guards.api.provider' => 'coach']);

            $coach = coach::select('coaches.*')->find(auth()->guard('coach')->user()->coach_id);
            $success =  $coach;
            $success['token'] =  $coach->createToken('MyApp',['coach'])->accessToken;
            $success['type'] = "coach";
            $success['success'] = true;

            $success['email_correct'] = coach::where('email', $request->email)->exists();
            return $success;
        }else{
            $success['email_correct'] = coach::where('email', $request->email)->exists();
            $success['success'] = false;
            return $success;
            //return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function userLogin(Request $request)
    {
        if(!str_contains((string)$request->email,'@')){
            $b = user::query()->where('username',request('email'))->get('email');
            if($b->isEmpty()){
                $success['email_correct'] = false;
                $success['success'] = false;
                return $success;
            }
            else{
                $request->email = ($b)[0]['email'];
            }
        }

        if(auth()->guard('user')->attempt(['email' => $request->email, 'password' => $request->password])){

            config(['auth.guards.api.provider' => 'user']);

            $user = user::select('users.*')->find(auth()->guard('user')->user()->user_id);    //i fucked up here
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken;
            $success['type'] = "user";
            $success['success'] = true;

            $success['email_correct'] = user::where('email', $request->email)->exists();

            return $success;
        }else{
            $success['email_correct'] = user::where('email', $request->email)->exists();
            $success['success'] = false;
            return $success;
            //return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function LogIn(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $b = $this->userLogin($request);

        if($b['success']){
            unset($b['email_correct']);
            return  $b;
        }
        else{
            if($b['email_correct']){
                return response()->json(['success'=>false,'errors'=>"password is wrong"],400);
            }
            $b = $this->coachLogin($request);
            if($b['success']){
                unset($b['email_correct']);
                return  $b;
            }
            else{
                if($b['email_correct']){
                    return response()->json(['success'=>false,'errors'=>"password is wrong"],400);
                }
                return response()->json(['success'=>false,'errors'=>"Email and Password are Wrong."],200);
            }
        }
    }
}
