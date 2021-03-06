<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodDonorController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'blood_group' => 'required',
        ]);
        $error = $validator->messages();
        if ($validator->fails()) {
            return $this->responseData($error, false);
        }

        $data = $request->all();
        $data['password']='1234';
        $user = User::create($data);
        return $this->responseData($user, true);
    }

    public function donate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
            'user_id'=>'required|exists:users,id',
        ]);
        $error = $validator->messages();
        if ($validator->fails()) {
            return $this->responseData($error, false);
        }

        $user = User::find($request->user_id);
        $user->lat = $request->lat;
        $user->lng = $request->lng;
        $user->available=1;
        $user->save();
        return $this->responseData("Thanks for donating",true);
    }

    public function getNearbyDonors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
            'blood_group'=>'required',
        ]);
        $error = $validator->messages();
        if ($validator->fails()) {
            return $this->responseData($error, false);
        }
        $lat = $request->lat;
        $lng = $request->lng;
        $blood_group= $request->blood_group;
        $users = User::where(['blood_group'=>$blood_group])->getNearbyDonors($lat, $lng)->get();
        return $this->responseData($users,true);
    }

    public function unavailable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required|exists:users,id',
        ]);
        $error = $validator->messages();
        if ($validator->fails()) {
            return $this->responseData($error, false);
        }
        $user = User::find($request->user_id);
        $user->available=0;
        $user->save();
        return $this->responseData("You have successfully marked yourself as unavailable",true);
    }

    private function responseData($message, $status)
    {
        return response()->json(["success" => $status, "message" => $message], 200);
    }
}
