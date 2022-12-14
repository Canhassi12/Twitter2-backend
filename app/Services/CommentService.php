<?php

namespace App\Services;

use App\Repositories\Comments\CommentsRepositoryInterface;
use App\Repositories\Posts\PostsRepositoryInterface;

class CommentService {

    public function __construct(CommentsRepositoryInterface $comments, PostsRepositoryInterface $posts)
    {
        $this->comments = $comments;
        $this->posts = $posts;
    }

    public function create($inputs) 
    {
        $post = $this->posts->findById($inputs['post_id']);

        $post->comments()->create(['user_id' => auth()->user()->id,...$inputs]);
    }

    public function delete(int $id): void
    {
        $this->comments->delete($id);
    }
}
