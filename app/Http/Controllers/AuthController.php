<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UsersRepositoryInterface;
use App\Services\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(AuthServiceInterface $auth, UsersRepositoryInterface $users)
    {
        $this->auth = $auth;
        $this->users = $users;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        
        return response()->json([
            "message" => "Login successful",
            "user" =>  $this->auth->login($credentials),
            "token" => auth()->user()->createToken('AuthToken')->plainTextToken
        ], Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
