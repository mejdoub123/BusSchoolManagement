<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $admin = new Admin(['cin' => $request->input('cin')]);

        $admin->save();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $admin->user()->save($user);
        $token = $user->createToken('crudtoken')->plainTextToken;
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_id' => $user->profile_id,
                'user_type' => $user->user_type
            ],
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        //Check email
        $user = User::where('email', $email)->first();
        //Check password
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Bad creds'
            ], 401);
        }
        $token = $user->createToken('crudtoken')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_id'=>$user->profile_id,
                'user_type' => $user->user_type
            ],
            'token' => $token
        ], 201);
    }

    public function update_password(Request $request)
    {

        //Validation 
        $fields = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);

        //Match the old password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'error' => 'Old password doesn\'t match!'
            ], 401);
        }

        //update the new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully!'
        ], 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ], 201);
    }
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
