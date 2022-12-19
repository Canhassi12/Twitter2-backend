<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostsRepositoryInterface
{
    public function delete($id): void;

    public function findById($id): ?Post;

    public function getPosts();

    public function getAllImagesFromUser(int $userID): Collection;
}   
