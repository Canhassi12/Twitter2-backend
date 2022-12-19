<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserException extends Exception
{
    public static function noUsers(): self
    {
        return new self(sprintf('No users found'), Response::HTTP_NOT_FOUND);
    }

    public static function invalidUserId(int $id): self
    {
        return new self(sprintf('User with id %s not found', $id), Response::HTTP_NOT_FOUND);
    }

    public static function userAlreadyFollowed(): self
    {
        return new self(sprintf('User has already followed'), Response::HTTP_NOT_FOUND);
    }

    public static function noFollowers(): self
    {
        return new self(sprintf('No followers found'), Response::HTTP_NOT_FOUND);
    }

    public function render() 
    {
        return response()->json($this->getMessage(), $this->code);
    }
}
