<?php 

namespace App\Services;

use App\Models\User;
use App\Repositories\Users\UsersRepositoryInterface;

interface AuthServiceInterface
{
    public function login(array $credentials): User;

    public function logout();
}
