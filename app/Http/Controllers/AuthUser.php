<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPerformance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
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
        
        UserPerformance::create([
            'user_id' => $user->id,
            'points' => 0,
            'question_solved' => 0,
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
    public function updateProfile(Request $request, $userID)
    {
        $user = User::find($userID);

        $validatedData = Validator::make($request->all(), [
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'sometimes|file|image|max:2048'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validatedData->messages()
            ], 422);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if it exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $file = $request->file('profile_photo');
            $path = $file->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }
    public function changePassword(Request $request, $userID)
    {
        $user = User::find($userID);

        $validatedData = Validator::make($request->all(), [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validatedData->messages()
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 422,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Password changed successfully'
        ], 200);
    }
}

