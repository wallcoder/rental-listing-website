<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPlan;
use Error;
use Exception;
use Filament\Events\Auth\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
            'current_plan'=>"free",
            'password'=>bcrypt($request->password)
        ]);

        // $userPlan = UserPlan::create([
        //     'user_id'=>$user->id,
        //     'plan_id'=>1,
        //     'is_active'=>true
        // ]);

        // event(new Registered($user));

        $token = JWTAuth::fromUser($user);
        $result = [
            'name'=>$user->name,
            'email'=>$user->email
        ];
        $ttl = config('jwt.ttl');

        return response()->json(['success'=>true, 'message'=>'User Created Successfully', 'data'=>$result])->cookie('token', $token, $ttl, '/', null, false,true, false, 'Lax' );

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

    public function editName(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                
                'name'=>'required'
            ]);

            if($validator->fails()){
                return response()->json(['success'=>false , 'message'=>$validator->errors()], 400);
            }

            $user = User::where('id', $request->user()->id)->update([
                'name' => $request->name
            ]);

            return response()->json(['success'=>'true', 'message'=>'Name has been updated', 200]);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request){
        try {
            $userId = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'current_password'=>'required',
                'password' =>  'required',
                'confirm_password' => 'required|same:password'
            ]);

            
            if($validator->fails()){
                return response()->json(['success'=>false , 'message'=>$validator->errors()], 400);
            }
            if(!$userId){
                return response()->json(['success'=>false , 'message'=>'Unauthorized access'], 401);
            }

            if (!Hash::check($request->current_password, $request->user()->password)) {
                return response()->json(['success' => false, 'message' => 'Invalid current password'], 401);
            }

            $user = User::where('id', $userId)->update(
                ['password'=>bcrypt($request->password)]
            );


            return response()->json(['success'=>'true', 'message'=>'Password has been updated', 200]);

            
        } catch (Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }


    public function deleteAccount(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                
            ]);

            if($validator->fails()){
                return response()->json(['success'=>false , 'message'=>$validator->errors()], 400);
            }

            $user  = User::where('id', $request->user()->id)->delete();
            

            return response()->json(['success'=>'true', 'message'=>'Account has been deleted', 200]);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

   
    public function handler (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return response()->json(['success'=>'true', 'message'=>'email verified'], 200);
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
            $ttl = config('jwt.ttl'); // returns JWT_TTL value
            return response()->json(['success'=>true, 'message'=>'Login Successful', 'data'=>$result], 200)->cookie('token', $token, $ttl, '/', null, false,true, false, 'Lax' );

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()]);
        }
        


        
    }
}
