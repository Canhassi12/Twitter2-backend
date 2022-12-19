<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\User;
use App\Repositories\Posts\PostsRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(UsersRepositoryInterface $users, PostService $postService)
    {
        $this->users = $users;
        $this->postService = $postService;
    }

    private function getUsers($followers)
    {
        if (!$this->users->getUsers($followers)) 
        {
            throw UserException::noUsers();
        }

        return $this->users->getUsers($followers);
    }

    public function store($inputs): User
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
        $followers = $this->users->getAllFollowersFromUserById($id);
        
        return $this->getUsers($followers);
    }

    public function followUser(int $id): void
    {
       $this->users->followUser($id);
    }
}
