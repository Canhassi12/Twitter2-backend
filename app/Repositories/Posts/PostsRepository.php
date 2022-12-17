<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use Illuminate\Support\Collection;

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

    public function getPosts()
    {
        return Post::paginate(20);
    }

    public function getAllImagesFromUser(int $userID): Collection
    {   
        return Post::all()->where('user_id', $userID)->pluck('image');
    }
}
