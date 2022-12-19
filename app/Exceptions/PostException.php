<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PostException extends Exception
{
    public static function invalidPostId(int $id): self
    {
        return new self(sprintf("Post with id %s not found", $id), Response::HTTP_NOT_FOUND);
    }

    public static function noPosts(): self
    {
        return new self(sprintf("No posts found"), Response::HTTP_NOT_FOUND);
    }

    public function render() 
    {
        return response()->json($this->getMessage(), $this->code);
    }
}
