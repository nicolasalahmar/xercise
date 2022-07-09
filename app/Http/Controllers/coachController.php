<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\constants;
use Illuminate\Support\Facades\Validator;
use App\Models\coach;
use App\Models\user;
use App\Models\requests;
use App\Models\program;
use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;


class coachController extends Controller
{

    public function saveImage($usr_id,$encodedImage){
        $path = constants::image_path;
        $imageName = 'coaches_'.($usr_id).'.jpg';
        $path = ($path).'coaches_'.($usr_id).'.jpg';
        $encodedImage = base64_decode($encodedImage);
        if(!gettype(file_put_contents(($path),$encodedImage)))
        {
            return false;
        }
        else {
                return true;
        }
    }

    public function showCoachProfile(Request $request){
        $coach = Auth::user(); //returns token's owner (coach who owns the token)
        $coach['type'] = "Coach";
        return response()->json([$coach]);
    }

    public function deleteCoachAccount(Request $request){
        $coach = Auth::user();
        return response()->json( ['success'=>$coach->delete()]);
    }

    public function editCoachProfile(Request $request){

        $coach = Auth::user();

        $validator = Validator::make($request->all(),[
            'FirstName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'LastName'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'gender'=>['required','in:Male,Female'],
            'encodedImage'=>['min:5'],
    		'description'=>['required'],
            'phone'=>['required','min:10','max:10'],
    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $coach->FirstName = $request->FirstName;
        $coach->LastName = $request->LastName;
        $coach->gender = $request->gender;
        $coach->description = $request->description;
        $coach->phone = $request->phone;

        if($request->has('encodedImage'))
            $this->saveImage((string)$coach->coach_id,$request->encodedImage);

        if($coach->save()){
            return response()->json(["success"=>true, "message"=>"info updated successfully!"]);
        }
        else {
            return response()->json(["success"=>false, "message"=>"Error editing profile."]);
        }
    }

    public function viewUserDashboard(){
        $users = user::query()->orderBy('duration','DESC')->limit(100)->get(['username','duration','image']);
        return response()->json( $users);
    }

    public function viewCoachDashboard(){
        $coaches = coach::query()->orderBy('rating', 'DESC')->limit(100)->get(['FirstName','LastName','rating','image']);
        return response()->json( $coaches);
    }

//to remove a plan published by coach (gets removed from users account as well)
    public function deletePlan(Request $request){
        $coach = Auth::user();
        if($request->has('program_id')){
            $req = program::query()->where('program_id', $request->program_id)->where('coach_id',$coach->coach_id)->delete();
            return response()->json( ['success'=>(boolean)$req]);
        }
    }

    public function viewPlans(){
        $coach = Auth::user();
        $plans = program::query()->where('coach_id', $coach->coach_id)->get('program_id');
        $arr = array();

        foreach($plans as $plan){
            $temp = program::where('program_id', $plan['program_id'])->first();
            //TODO time per day and times a week must be added to programs table (make them text)
            array_push($arr,$temp);
        }
        return response()->json($arr);
    }
}
