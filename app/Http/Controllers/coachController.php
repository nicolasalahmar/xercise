<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\constants;
use Illuminate\Support\Facades\Validator;
use App\Models\coach;
use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;


class coachController extends Controller
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

    public function showCoachProfile(Request $request){
        $coach = Auth::user(); //returns token's owner (coach who owns the token)
        $coach['type'] = "Coach";
        return response()->json([$coach]);
    }

    public function deleteCoachAccount(Request $request){
        $user = Auth::user();
        return response()->json( ['success'=>$user->delete()]);
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
}
