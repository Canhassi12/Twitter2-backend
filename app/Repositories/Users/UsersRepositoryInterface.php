<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Collection;

interface UsersRepositoryInterface
{
    public function create(array $inputs): User;

    public function delete(int $id): void;

    public function findByEmail(string $email): User;

    public function getAllFollowersFromUserById(int $id): Collection;

    public function followUser(int $id): void;
}
