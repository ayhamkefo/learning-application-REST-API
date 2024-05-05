<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthUser extends Controller
{
    // AuthController.php

 
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validatedData->messages()
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'user registered successfully',
            'token' => $token,
        ], 200);
    }

    public function login(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'device_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validatedData->messages()
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user||!Hash::check($request->password, $user->password)){
            return response()->json([
                "status" => 422,
                "message" => 'Invalid Password Or Eamil Pleas Try Again',
            ],422);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'user login successfully',
            'token' => $token,
        ], 200);
    }
    public function logout(Request $request ){
        $user=$request->user();
        $user->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'user logout successfully',
        ], 200);
    }
    function getCurrentUser(Request $request){
        return response()->json($request->user() , 200);
    }
}
