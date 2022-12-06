<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $users;

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

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
   
    public function register(UserStoreRequest $request, CreateUser $action)
    {
        $inputs = $request->validated();

        return response()->json([
            'message'  => 'User has been created in database',
            'user'     =>  $user = $action->handle($inputs),
            'token'    => $user->createToken('AuthToken')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response()->json('Logout successfully', Response::HTTP_NO_CONTENT);
    }
}
