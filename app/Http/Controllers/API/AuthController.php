<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $user->load('profile');
        // Buat token personal access (Sanctum)
        $accessToken = $user->createToken('access_token', ['*']);
        return (new JsonResource([
            'access_token' => $accessToken->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ]))->response();
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('profile');
        return new EmployeeResource($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
