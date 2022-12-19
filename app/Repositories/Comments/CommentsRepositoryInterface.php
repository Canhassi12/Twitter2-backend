<?php

namespace App\Repositories\Comments;

use App\Models\Comment;

interface CommentsRepositoryInterface
{
    public function findById($id): ?Comment;

    public function delete($id): void;
}
