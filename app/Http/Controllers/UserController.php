<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\UseCases\User\UserCrudUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * @group Users
 * @authenticated
 */
class UserController extends SimpleEntityCrudController
{
    protected $useCase;
    protected $resource;

    public function __construct()
    {
        $this->useCase = new UserCrudUseCase();
        $this->resource = UserResource::class;
    }

    public function index()
    {
        return parent::index();
    }

    public function create(StoreUserRequest $request): JsonResponse
    {
        return parent::store($request);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return parent::save($request, $user);
    }

    public function remove(DeleteUserRequest $request, User $user)
    {
        return parent::delete($user);
    }
}
