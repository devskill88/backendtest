<?php

namespace App\Services\Auth;

use App\Contracts\Auth\APIAuthenticatorInterface;
use App\Models\User;

class SanctumAuthenticator implements APIAuthenticatorInterface
{
    public static function getToken(string $user, string $password) :string
    {
        if (!auth()->attempt(['email' => $user, 'password' => $password])){
            return false;
        }

        $token = auth()->user()->createToken('api-token');
        return $token->plainTextToken;
    }

    public static function logOut(User $user): void
    {
        $user->tokens()->delete();
    }
}