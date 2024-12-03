<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {

        try {

            $user_name = $request->input('user_name');
            $password = $request->input('password');

            $user = User::where('user_name', '=', $user_name)
                ->where('password', '=', $password)
                ->first();

            if ($user !== null) {

                $token = JWTToken::CreateToken($user->user_name, $user->id, $user->role);

                return response()->json([
                    'success' => true,
                    'message' => "Login successful."
                ])->cookie('token', $token, 60);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => "Unauthorized"
                ]);
            }
        } 
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ]);
        }
    }

    public function createUser(Request $request){

        try{

            User::create([
                'user_name' => $request->input('user_name'),
                'password' => $request->input('password'),
            ]);

            return response()->json([
                'success' => true,
                'message' => "User created successfully."
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ]);
        }
    }
}
