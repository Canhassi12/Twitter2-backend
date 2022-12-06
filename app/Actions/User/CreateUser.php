<?php 

namespace App\Actions\User;

use App\Models\User;
use App\Repositories\Users\UsersRepository;

class CreateUser 
{
    private UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function handle(mixed $inputs): User
    {
        return $this->repository->create($inputs);
    }
}