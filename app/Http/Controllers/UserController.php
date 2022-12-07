<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Actions\User\DeleteUser;
use App\Http\Requests\UserStoreRequest;
use App\Repositories\Users\UsersRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function store(UserStoreRequest $request, CreateUser $action)
    {
        $inputs = $request->validated();

        return response()->json([
            'message'  => 'User has been created in database',
            'user'     =>  $user = $action->handle($inputs),
            'token'    => $user->createToken('AuthToken')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function destroy($id, DeleteUser $action) 
    {
        $action->handle($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
