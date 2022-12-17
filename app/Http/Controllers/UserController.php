<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(UserService $user)
    {
        $this->users = $user;
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        return response()->json([
            'message'  => 'User has been created in database',
            'user'     =>  $user = $this->users->store($inputs),
            'token'    => $user->createToken('AuthToken')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json([$this->users->delete($id)], Response::HTTP_NO_CONTENT);
    }
}
