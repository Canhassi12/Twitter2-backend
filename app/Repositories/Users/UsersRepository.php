<?php 

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersRepository implements UsersRepositoryInterface
{
    public function create(array $inputs): User
    {
        $inputs['password'] = Hash::make($inputs['password']);
        return User::create($inputs);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }
}

