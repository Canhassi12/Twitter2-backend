<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CommentException extends Exception
{
    public static function invalidCommentId($id) 
    {
        return new self(sprintf('Comment with id %s not found', $id), Response::HTTP_NOT_FOUND);
    }

    public function render() 
    {
        return response()->json($this->getMessage(), $this->code);
    }
}
