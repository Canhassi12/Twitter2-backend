<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Services\PostService;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(PostService $post)
    {
        $this->post = $post;
    }


    public function index()
    {
       
    }

    
    public function store(PostStoreRequest $request)
    {
        $this->post->create($request);
   
        return response()->json(['the post has been created'], Response::HTTP_CREATED);
    }

    
    public function destroy($id)
    {
        $this->post->delete($id);
                
        return response()->json([], Response::HTTP_NO_CONTENT);   
    }
}
