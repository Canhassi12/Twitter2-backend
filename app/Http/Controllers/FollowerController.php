<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FollowerController extends Controller
{
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function showFollowers($id): JsonResponse
    {
       $followers = $this->user->getAllFollowersFromUser($id);
        return response()->json($followers, Response::HTTP_OK);
    }

    public function followUser($id): JsonResponse
    {
        $this->user->followUser($id);
        return response()->json([], Response::HTTP_OK);
    }
}
