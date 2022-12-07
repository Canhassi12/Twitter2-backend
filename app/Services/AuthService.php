<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Users\UsersRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function login(array $credentials): User
    {
        VerifyUserCredentialsService::validationUserCredentials($credentials);

        return $this->users->findByEmail($credentials['email']);
    }

    public function logout()
    {
    
    }
}
