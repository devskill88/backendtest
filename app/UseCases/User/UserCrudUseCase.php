<?php

namespace App\UseCases\User;

use App\Models\User;
use App\Repositories\DatabaseRepositoryInterface;
use App\Repositories\UserRepository;
use App\Traits\ApiResponse;
use App\UseCases\SimpleCrudUseCaseBase;

class UserCrudUseCase extends SimpleCrudUseCaseBase
{

    use ApiResponse;
    
    public static function repo(): DatabaseRepositoryInterface
    {
        return new UserRepository(new User());
    }

    public static function render($data, string $message = '')
    {
        return static::successResponse($data, $message);
    }

}