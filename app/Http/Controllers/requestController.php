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

use Auth;
use Storage;
use DB;
use DateTime;
use Carbon\Carbon;

class requestController extends Controller
{
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
        $req = requests::query()->where('user_id',$user->user_id)->get(['request_id','name','status','created_at','coach_id']);

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

    public function requestPlan(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'coach_id'=>['required','exists:coaches,coach_id'],
            'name'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
    		'objective'=>['required','min:3','regex:/^[a-zA-Z ]+$/'],
            'message'=>['min:0'],
            'days'=>['required','in:1,2,3,4,5'],
            'time_per_day'=>['required','in:10,15,20,25,30,35,40'],

    	]);

    	if($validator->fails()){
    		return $validator->errors()->all();
    	}

        $req = new requests();
        $req->user_id = $user->user_id;
        $req->coach_id = $request->coach_id;
        $req->name = $request->name;
        $req->time_per_day = $request->time_per_day;
        $req->days = $request->days;
        $req->objective = $request->objective;
        $req->message = $request->message;
        $req->status = 'pending';

        if($req->save()){
            return response()->json(["success"=>true, "message"=>"Request Has Been Sent Successfully"]);
        }
        else {
            return response()->json(["success"=>false, "message"=>"Error Sending Request"]);
        }
    }
}
