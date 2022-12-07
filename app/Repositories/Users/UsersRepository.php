<?php 

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersRepository {

    public function create($inputs) 
    {
        $inputs['password'] = Hash::make($inputs['password']);
        return User::create($inputs);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}

