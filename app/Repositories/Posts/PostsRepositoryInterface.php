<?php

namespace App\Repositories\Posts;

use App\Models\Post;

interface PostsRepositoryInterface
{
    public function delete($id): void;

    public function findById($id): Post;
}   
