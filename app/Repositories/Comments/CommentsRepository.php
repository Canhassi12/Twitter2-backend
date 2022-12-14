<?php

namespace App\Repositories\Comments;

use App\Models\Comment;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function findById($id): Comment
    {
        return Comment::where('id', $id)->first();
    }

    public function delete($id): void
    {
        Comment::destroy($id);
    }
}
