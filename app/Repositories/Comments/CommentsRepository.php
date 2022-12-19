<?php

namespace App\Repositories\Comments;

use App\Exceptions\CommentException;
use App\Models\Comment;
use Exception;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function findById($id): ?Comment
    {
        return Comment::where('id', $id)->first();
    }

    public function delete($id): void
    {
        Comment::destroy($id); 
    }
}
