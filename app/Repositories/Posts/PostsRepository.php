<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use Exception;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\isEmpty;

class PostsRepository implements PostsRepositoryInterface
{
    public function delete($id): void
    {
        Post::destroy($id);
    }

    public function findById($id): ?Post
    {
        return Post::where('id', $id)->first();
    }

    public function getPosts()
    {
        if(!Post::all()->take(20)->isempty()) {
            return Post::all()->take(20);
        }    
    }

    public function getAllImagesFromUser(int $userID): Collection
    {   
        return Post::all()->where('user_id', $userID)->pluck('image');
    }
}
