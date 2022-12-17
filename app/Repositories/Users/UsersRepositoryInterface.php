<?php

namespace App\Repositories\Users;

use App\Models\User;

interface UsersRepositoryInterface
{
    public function create(array $inputs): User;

    public function delete(int $id): void;

    public function findByEmail(string $email): User;

    public function getAllFollowersFromUserById(int $id);

    public function followUser(int $id): void;
}
