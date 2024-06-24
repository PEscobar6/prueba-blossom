<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|min:8',
        ]);

        $credentials = request(['email', 'password']);
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid email or password',
                    'status' => 401
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Could not create token',
                'status' => 500
            ], 500);
        }

        $user = Auth::user();

        return jsonResponse(data: [
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
        ], message: 'Login successful', status: 200);
    }
}
