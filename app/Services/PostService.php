<?php 

namespace App\Services;

use App\Models\Post;
use App\Repositories\Posts\PostsRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostService 
{
    public function __construct(PostsRepositoryInterface $posts)
    {
        $this->posts = $posts;
    }

    private function storeImagesInPublicFolder($request): void
    {
        if (!empty($request['image'])) {

            Storage::disk('local')->putFile('', $request['image']); //refactor 
        }
    }

    private function deleteImageFromPublicFolder(Post $post): void 
    {
        File::delete(public_path('storage/images/'.$post->image));
    }
    
    public function deleteAllImagesFromUserinPublicFolder(int $userID) 
    {
        $imagesName = $this->posts->getAllImagesFromUser($userID);
        
        foreach ($imagesName as $image) {
            File::delete(public_path('storage/images/'.$image));
        }
        
    }

    public function create($request): void 
    {
        $this->storeImagesInPublicFolder($request);
        
        $inputs = $request->validated();

        $inputs['image'] = $inputs['image']->hashName();

        auth()->user()->posts()->create($inputs);       
    }

    public function delete(int $id): void
    {
        $post = $this->posts->findById($id);

        $this->deleteImageFromPublicFolder($post);

        $this->posts->delete($id);
    }

    public function getPosts()
    {
        $posts = $this->posts->getPosts();

        foreach ($posts as $post) {
            $post->image = asset('storage/images/'.$post->image);
        }
        
        return $posts;
    }
}
