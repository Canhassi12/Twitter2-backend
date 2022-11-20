<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials, true)) {
            return response()->json('Invalid email or password', Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $credentials['email'])->get();

        return response()->json( [
            "message" => "Login successful",
            "token" => auth()->user()->createToken('AuthToken')->plainTextToken,
            "user" => $user,
        ], Response::HTTP_OK);
    }
   
    public function register(UserStoreRequest $request)
    {
        $inputs = $request->validated();

        $inputs['password'] = Hash::make($inputs['password']);

        $user = User::create(
            $inputs
        );

        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'message'  => 'User has been created in database',
            'token'    => $token,
            'user'     => $user
        ], Response::HTTP_CREATED);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response()->json('Logout successfully', Response::HTTP_NO_CONTENT);
    }
}
