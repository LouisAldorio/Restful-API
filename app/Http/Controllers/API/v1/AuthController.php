<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Http\Resources\userResources;
use App\Http\Requests\userLoginRequest as LoginUser;
use App\Http\Requests\userRegisterRequest as RegisterUser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUser $request){
       $hashedPassword = Hash::make($request->password);
       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword
       ]);
       $token = $user->createToken('Laravel Password Grant Client')->accessToken;
       return response()->json([
            'token' => $token,
            'data' => $user
        ]);
    }

    public function login(LoginUser $request){
        $hashedPassword = Hash::make($request->password);
        $email = $request->email;
        $user = User::where('email',$email)->first();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'token' => $token,
            'data' => $user
        ]);
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'you are logged out!']);
    }
}
