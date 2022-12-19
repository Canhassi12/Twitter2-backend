<?php

namespace App\Services;

use App\Exceptions\CommentException;
use App\Exceptions\PostException;
use App\Repositories\Comments\CommentsRepositoryInterface;
use App\Repositories\Posts\PostsRepositoryInterface;
use Exception;

class CommentService {

    public function __construct(CommentsRepositoryInterface $comments, PostsRepositoryInterface $posts)
    {
        $this->comments = $comments;
        $this->posts = $posts;
    }

    public function create($inputs) 
    {
        if (empty($post = $this->posts->findById($inputs['post_id']))) {
            throw PostException::invalidPostId($inputs['post_id']);
        }

        $post->comments()->create(['user_id' => auth()->user()->id,...$inputs]);
    }

    public function delete(int $id): void
    {
        if (empty($this->comments->findById($id))) {
            throw CommentException::invalidCommentId($id);
        }

        $this->comments->delete($id);
    }
}
