<?php

namespace App\Repositories\Posts;

use App\Models\Post;

class PostsRepository implements PostsRepositoryInterface
{
    public function delete($id): void
    {
        Post::destroy($id);
    }

    public function findById($id): Post
    {
        return Post::where('id', $id)->first();
    }
}
