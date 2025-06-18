<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface APIAuthenticatorInterface
{
    public static function getToken(string $user, string $password): string;

    public static function logout(User $user) : void;
}