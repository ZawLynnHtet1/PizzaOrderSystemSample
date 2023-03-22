<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Passport\Passport;

class AuthApiController extends Controller
{
    public function apilogin(Request $request){
        $validator = $request->validate([
            'email'=> 'required|string',
            'password'=>'required|string',
        ]);
        $user = User::where('email',$request->email)->first();

        if(empty($user) || !Hash::check($request->password, $user->password)){
            return Response::json(['status'=>200,'message'=>'Credential do not match.']);
        }

        $token = $user->createToken('myAuthToken')->plainTextToken;
        $user->token=$token;

        return Response::json(['user'=>$user],200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return Response::json(['message'=>'Logout Success'],200);
    }

    public function register(Request $request){
        $validator = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'phone' => 'required',
            'password' => 'string|required|confirmed',
            'address' => 'string|required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('myAppToken')->plainTextToken;

        Return Response::json(['message' => 'new user created successfully',
        'status' => 200,
        'user' => $user,
        'token' =>$token ]);
    }
}
