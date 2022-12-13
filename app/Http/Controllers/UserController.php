<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        return response()->json([
            'message'  => 'User has been created in database',
            'user'     =>  $user = $this->users->create($inputs),
            'token'    => $user->createToken('AuthToken')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->users->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
