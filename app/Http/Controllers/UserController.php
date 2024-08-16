<?php

namespace App\Http\Controllers;

use App\Models\UserRealest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function user(Request $request){
        try{
            $validated = Validator::make($request->all(),[
                'username' => 'required|string|max:255|unique:user_realests',
                'password' => 'required|string|confirmed|min:6'
            ]);
           
            if($validated->fails()){
                return response()->json(['error'=> $validated->errors()]);
            };

            
            $messages = new UserRealest();
            $messages->username = $request->username;
            $messages->password = Hash::make($request->password);
            $messages->save();
            
            return response()->json(['username'=> $request->get('username'), 'password' => $request->get('password')]);
        } catch(Exception $e){
            return response()->json(['error' => $e->getMessage()],400);
        }
    }


    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        
        $credentials = $request->only('username','password');
        try{
            if($validate->fails()){
                return response()->json(['error'=>$validate->errors()],400);
            }


            if(Auth::attempt($credentials)){
                $user = UserRealest::where('username',$request->username)->first();
                return response()->json(['username'=> $request->username,'user_id' => $user->id]); 
            }
            return response()->json(['error' =>"Invalid Username or Password"],401);
        } catch (Exception $e){
            return response()->json(['error' =>$e->getMessage()]);
        }
    }

    public function singleUser(Request $request){

        $user = UserRealest::where('username', $request->username)->first();
        return response()->json(['user'=>$user]);
    }
}
