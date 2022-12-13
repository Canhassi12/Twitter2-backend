<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Users\UsersRepositoryInterface;
use App\Services\VerifyUserCredentialsService;

class AuthService
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
