<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWT;

class AuthController extends Controller
{
   


    public function register(Request $request){

        try{

      
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' =>  'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json(['success'=>false , 'message'=>$validator->errors()], 400);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

       $token = JWTAuth::fromUser($user);
        $result = [
            'name'=>$user->name,
            'email'=>$user->email
        ];
      

        return response()->json(['success'=>true, 'message'=>'User Created Successfully', 'data'=>$result])->cookie('token', $token, 15, '/', null, false,true, false, 'Lax' );

    }catch(Exception $e ){
        return response()->json(['success'=>false, 'message'=>$e->getMessage()]);


    }


    }


    public function logout(Request $request){
        try{
            return response()->json(['success' => true, 'message' => 'Logged out successfully'])
            ->cookie('token', '', -1); 

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }

    public function checkToken(Request $request){
        try{

        
        $token = $request->cookie('token');
        $user = JWTAuth::setToken($token)->authenticate();
        $result = [
            'name'=>$user->name,
            'email'=>$user->email
        ];
        return response()->json(['success'=>true, 'message'=>'Token is valid', 'data'=>$result], 200);
    }catch(Exception $e){
        return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
    }
    }
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'      
            ]);
    
            if($validator->fails()){
                return response()->json(['success'=>false, 'message'=>$validator->errors()], 400);
                
            }

            $credentials = $request->only('email', 'password');

            if(!Auth::attempt($credentials)){
                return response()->json(['success'=>false, 'message'=>'Invalid Credentials'], 401);
            }

            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            $result = [
                'name'=>$user->name,
                'email'=>$user->email,
                
            ];

            return response()->json(['success'=>true, 'message'=>'Login Successful', 'data'=>$result], 200)->cookie('token', $token, 15, '/', null, false,true, false, 'Lax' );

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
        


        
    }
}
