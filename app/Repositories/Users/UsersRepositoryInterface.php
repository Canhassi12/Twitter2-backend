<?php

namespace App\Repositories\Users;

use App\Models\User;

interface UsersRepositoryInterface
{
    public function create(array $inputs): User;

    public function delete($id);

    public function findByEmail(string $email): User;
}
