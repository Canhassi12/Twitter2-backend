<?php

namespace App\Services;

use App\Repositories\Posts\PostsRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;

class UserService
{
    public function __construct(UsersRepositoryInterface $users, PostService $postService)
    {
        $this->users = $users;
        $this->postService = $postService;
    }

    public function store($inputs)
    {
        return $this->users->create($inputs);
    }

    public function delete(int $id): void
    {
        $this->postService->deleteAllImagesFromUserinPublicFolder($id);
        $this->users->delete($id);
    }

    public function getAllFollowersFromUser(int $id)
    {
        return $this->users->getAllFollowersFromUserById($id);
    }

    public function followUser(int $id): void
    {
        $this->users->followUser($id);
    }
}
