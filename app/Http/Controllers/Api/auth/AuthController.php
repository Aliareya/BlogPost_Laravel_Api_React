<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Log::info('Registering user with email:');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
            'is_admin' => false,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'status' => 201,
        ]);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
                'status' => 401,
            ], 401);
        }

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Set cookie
        $cookie = cookie(
            'auth_token',    // Cookie name
            $token,          // Token value
            60 * 24,         // Expiration in minutes (7 days)
            '/',             // Path
            null,            // Domain (null = localhost)
            false,           // Secure (set to true if using https)
            true,            // HttpOnly
            false,           // Raw
            'Strict'         // SameSite policy
        );

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'status' => 200,
        ])->withCookie($cookie);
    }
}
