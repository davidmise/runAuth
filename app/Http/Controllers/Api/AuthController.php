<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Your registration logic here
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('runApp')->plainTextToken;

        return response()->json(['runApp-register-token' => $token, 'user' => $user]);
    }

    public function login(Request $request)
    {
        // Your login logic here
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            // $token = $user->createToken('runApp')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'runApp-login-token' => $user->createToken('runApp')->plainTextToken,
                'user' => $user
                ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'],
             401);
        }
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }


    public function test_api(Request $request)
    {
        $id = $request->id;
        return response()->json([
            'success' => true,
            'id' => $id
        ]);
    }
}
