<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials, true)) {
            return response()->json('Invalid email or password', Response::HTTP_UNAUTHORIZED);
        } //refatorar

        $user = User::where('email', $credentials['email'])->get(); //refatorar

        return response()->json( [
            "message" => "Login successful",
            "token" => auth()->user()->createToken('AuthToken')->plainTextToken,
            "user" => $user,
        ], Response::HTTP_OK);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response()->json('Logout successfully', Response::HTTP_NO_CONTENT);
    }
}
