<?php

namespace App\UseCases\Auth;

use App\Contracts\Auth\APIAuthenticatorInterface;

class AuthenticateUserUseCase
{
    public APIAuthenticatorInterface $authenticator;

    public function __construct(APIAuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }
}