<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserCredentialsService
{
    static function validationUserCredentials($credentials) 
    {
        if (!Auth::attempt($credentials, true)) {
            return response()->json('Invalid email or password', Response::HTTP_UNAUTHORIZED); //REFACTOR exception
        } 
    }
}
