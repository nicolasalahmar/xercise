<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\user;
use App\Models\trainee;
use App\Models\coach;
use Illuminate\Auth\AuthenticationException;

use Auth;
use Storage;
use DB;
use DateTime;

class AuthController extends Controller
{
    public function saveImage($usr_id,$encodedImage){
        $imageName = 'user_'.($usr_id).'.jpg';
        $imagePath = 'D:/Laravel Projects/Xercise/storage/app/Images/'.'user_'.($usr_id).'.jpg';
        $encodedImage = base64_decode($encodedImage);
        if(!gettype(file_put_contents($imagePath,$encodedImage)))
        {
            return false;
        }
        else {
            DB::table('users')->where('usr_id',$usr_id)->update(['image'=>$imageName]);
            return true;
        }
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(),[
            'FirstName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'LastName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'username'=>['required','min:3','unique:users'],
            'encodedImage'=>['min:5'],
            'email'=>['required','email:rfc,dns','unique:users'],
            'password'=>['required','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'gender'=>['required','in:Male,Female'],
            'type'=>['required','in:trainee,coach'],
        ]);
        if($validator->fails()){
            return $validator->errors()->all();
        }

        $request['password']=Hash::make($request['password']);

        $FirstName=$request->FirstName;
        $LastName=$request->LastName;
        $email=$request->email;
        $gender=$request->gender;
        $username = $request->username;
        $password=$request->password;
        $type = $request->type;

        $user = user::query()->create([
        	'FirstName'=>$FirstName,
            'LastName'=>$LastName,
        	'email'=>$email,
        	'password'=>$password,
            'gender'=>$gender,
            'username'=>$username,
            'image'=>null,
            'type'=>$type,
        ]);

        if($user->usr_id){
            if($request->type=='trainee'){
                $b = $this->createTrainee($request,$user->usr_id);
                if(gettype($b) == "boolean" && $b){     //when it's not boolean validator error when it is false DB error when it's true DB correct
                    if($request->has('encodedImage')){
                        if(!$this->saveImage((string)$user->usr_id,$request->encodedImage)){
                            return response()->json(['success'=>true,'message'=>'Trainee created successfully','image'=>false]);
                        }
                    }
                    return response()->json(['success'=>true,'message'=>'Trainee created successfully','image'=>true]);
                }
                else{
                    DB::table('users')->where('usr_id',$user->usr_id)->delete();
                    return response()->json([$b]);
                }
            }
            else{
                $b = $this->createCoach($request,$user->usr_id);
                if(gettype($b) == "boolean" && $b){
                    if($request->has('encodedImage')){
                        if(!$this->saveImage((string)$user->usr_id,$request->encodedImage)){
                            return response()->json(['success'=>true,'message'=>'Coach created successfully','image'=>false]);
                        }
                    }
                    return response()->json(['success'=>true,'message'=>'Coach created successfully','image'=>true]);
                }
                else{
                    DB::table('users')->where('usr_id',$user->usr_id)->delete();
                    return response()->json([$b]);
                }
            }
        }
        else{
            return response()->json(['success'=>false,'message'=>'User could not be created.']);
        }
    }

    public function createTrainee(Request $request,$usr_id){
        $validator = Validator::make($request->all(),[
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

        $Trainee = trainee::query()->create([
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
            'usr_id'=>$usr_id,
            'active_program'=>null,
        ]);

        if($Trainee->trainee_id)
            return true;
        else
            return false;
    }

    public function createCoach(Request $request,$usr_id){
        $validator = Validator::make($request->all(),[
    		'description'=>['required'],
            'coach_num'=>['required','min:6','max:6'],
            'phone'=>['required','min:10','max:10'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $description = $request->description;
        $coach_num = $request->coach_num;
        $phone = $request->phone;

        $contents = json_decode(Storage::get('coaches.json'),true);

        //return $contents;
        if (!isset( $contents[$coach_num])){
            return response()->json(['success'=>false,'message'=>"coach id not found"],400);
        }
        else if ($contents[$coach_num]['active']){
            return response()->json(['success'=>false,'message'=>"coach id already taken and active"],400);
        }

        $contents[$coach_num]['active']=true; //set coach to active
        Storage::disk('local')->put('coaches.json', json_encode($contents));

        $coach = coach::query()->create([
        	'description'=>$description,
            'coach_num'=>$coach_num,
            'phone'=>$phone,
            'usr_id'=>$usr_id,
            'rating'=>0,
        ]);


        if($coach->coach_id)
            return true;
        else
            return false;

    }

    public function LogIn(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>['required'],
    		'password'=>['required','min:8'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $password=$request->password;
        $email=$request->email;

        $userEmail = DB::table('users')->where('email',$email)->get('email');

        if ($userEmail->isEmpty()){
            $userUsername = DB::table('users')->where('username',$email)->get('email');
            if ($userUsername->isEmpty()){
                return response()->json(['success'=>false,'message'=>"User not found"],400);
            }
            else{
                $email = $userUsername[0]->email;
            }
        }
        else{
            $email = $userEmail[0]->email;
        }

        if(!Auth::attempt(['email'=>$email,'password'=>$password])){
            return response()->json(['success'=>false,'message'=>'Invalid password']);
        }
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token');

        return response()->json(['token'=>$token->accessToken,'token_type'=>'Bearer']);
    }

    public function logOut(){
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success'=>true,'message'=>'Logged out successfully.']);
    }

    public function splashScreen(Request $request){
        return response()->json(['success'=>true]);
    }
}
