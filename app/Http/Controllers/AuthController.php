<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
        // 'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' =>$validator->errors()], 401);
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('myApp')->accessToken;
            $apitoken = User::where('email',$request->email)->first();
            $apitoken->api_token = $success['token'];
            $apitoken->save();
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        // 'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' =>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('myApp')->accessToken;
        $success['name'] = $user->name;
        $apitoken = User::where('email',$request->email)->first();
        $apitoken->api_token = $success['token'];
        $apitoken->save();
       
        return response()->json(['success' =>$success], 200);
    }
    public function logoutApi(Request $request)
    {
        // if(auth()->user()){
        //         return response()->json(['success' =>auth()->user()], 200);

        // }
        // else{
        //           return response()->json(['success' => 'not there'], 200);
  
        // }
        // dd(auth('api')->user());      
        $apitoken = User::where('email', auth()->user()->email)->first();
        $apitoken->api_token = null;
        $apitoken->save();
        return response()->json(['success' => 'Logout Successful'], 200);

    }

}
