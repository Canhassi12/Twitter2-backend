<?php 

namespace App\Repositories\Users;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersRepository implements UsersRepositoryInterface
{
    public function create(array $inputs): User
    {
        $inputs['password'] = Hash::make($inputs['password']);
        return User::create($inputs);
    }

    public function delete(int $id): void
    {
        User::destroy($id);
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    public function getAllFollowersFromUserById(int $id)
    {
        return Follower::all()->where('user_id', $id);
    }

    public function followUser(int $id): void
    {
        Follower::create([
            'user_id' => $id,
            'follower_id' => auth()->user()->id,
        ]);
    }
}
