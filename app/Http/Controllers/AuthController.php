<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthUserRequest;
use App\Services\Auth\SanctumAuthenticator;
use App\Traits\ApiResponse;
use App\UseCases\Auth\AuthenticateUserUseCase;
use Illuminate\Http\Request;

/**
 * @group Auth
 */
class AuthController extends Controller
{
    use ApiResponse;

    protected $useCase;

    public function __construct()
    {
        $this->useCase = new AuthenticateUserUseCase(new SanctumAuthenticator());
    }

    /**
     * @group Authentication
     *
     * Get access token
     */
    public function getToken(AuthUserRequest $request)
    {
        $token = $this->useCase->authenticator::getToken($request->email, $request->password);
        if (!$token){
            return static::unsuccessResponse('Invalid credentials', 401);
        }

        return static::successResponse(['token' => $token]);
    }

    /**
     * Logout
     * 
     * @group Authentication
     * @authenticated
     */
    public function logOut()
    {
        $this->useCase->authenticator::logout(auth()->user());
        return static::successResponse([], 'Logout successfully');
    }

    /**
     * Requester
     * 
     * @group Authentication
     * @authenticated
     */
    public function getRequester()
    {
        return static::successResponse([], '');
    }
}
