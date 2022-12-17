<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(PostService $post)
    {
        $this->post = $post;
    }

    public function index(): JsonResponse
    {
       return response()->json(["posts" => $this->post->getPosts()], Response::HTTP_OK);
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $this->post->create($request);
   
        return response()->json('the post has been created', Response::HTTP_CREATED);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json([$this->post->delete($id)], Response::HTTP_NO_CONTENT);   
    }
}
