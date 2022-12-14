<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function __construct(CommentService $comment)
    {
        $this->comment = $comment;
    }

    public function store(CommentStoreRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        $this->comment->create($inputs);

        return response()->json('the comment has been created', Response::HTTP_CREATED);
    }
  
    public function destroy(int $id): JsonResponse
    {
        $this->comment->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
