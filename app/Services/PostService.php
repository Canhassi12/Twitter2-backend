<?php 

namespace App\Services;

use App\Exceptions\PostException;
use App\Models\Post;
use App\Repositories\Posts\PostsRepositoryInterface;
use Illuminate\Support\Collection;
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
    
    public function deleteAllImagesFromUserinPublicFolder(int $userID): void
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

        if (!empty($request['image'])) {
            $inputs['image'] = $inputs['image']->hashName();    
        }

        auth()->user()->posts()->create($inputs);       
    }

    public function delete(int $id): void
    { 
        if(!$post = $this->posts->findById($id)) {
            throw PostException::invalidPostId($id);
        }

        if($post->image) {
            $this->deleteImageFromPublicFolder($post);
        }

        $this->posts->delete($id);
    }

    public function getPosts(): Collection
    {
        if (!$posts = $this->posts->getPosts()) {
            throw PostException::noPosts();
        }
      
        foreach ($posts as $post) {
            $post->image = asset('storage/images/'.$post->image);
        }
        
        return $posts;
    }

    public function likePost(int $id): Post
    {
        if (!$post = $this->posts->findById($id)) {
            throw PostException::invalidPostId($id);
        }

       
        $post->likes()->create([
            'user_id' => auth()->user()->id,
            'id_like' => $id,
        ]);

        return $post;
    }
}
