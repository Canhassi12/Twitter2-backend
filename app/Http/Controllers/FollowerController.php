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
       return response()->json(["followers" => $this->user->getAllFollowersFromUser($id)], Response::HTTP_OK);
    }

    public function followUser($id): JsonResponse
    {
        return response()->json([$this->user->followUser($id)], Response::HTTP_OK);
    }

    
}
