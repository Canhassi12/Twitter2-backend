<?php 

namespace App\Repositories\Users;

use App\Exceptions\UserException;
use App\Models\Follower;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class UsersRepository implements UsersRepositoryInterface
{
    private function checkIfUserAlreadyFollowed($id) {
        if (Follower::where('user_id', $id)->where('id_followed', auth()->user()->id)->first()) {
            throw UserException::userAlreadyFollowed();
        }
    }
    public function create(array $inputs): User
    {
        $inputs['password'] = Hash::make($inputs['password']);
        return User::create($inputs);
    }

    public function delete(int $id): void
    {
        if(!User::destroy($id)) {
            throw UserException::invalidUserId($id);
        }
    }

    public function findByEmail(string $email): User
    {   
        return User::where('email', $email)->first();
    }

    public function getUsers($followers): array
    {
        $users = [];
        foreach ($followers as $follower) {
            array_push($users, User::where('id', $follower->user_id)->first());
        }

        return $users;
    }

    public function getAllFollowersFromUserById(int $id): Collection
    {  
        return Follower::all()->where('user_id', $id);
    }

    public function followUser(int $id): void
    {
        $this->checkIfUserAlreadyFollowed($id);

        try {
            Follower::create([
                'user_id' => $id, 
                'id_followed' => auth()->user()->id
            ]);  
        } catch (Exception $e) {
            throw UserException::invalidUserId($id);
        }
    }
}
