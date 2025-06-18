<?php

namespace App\UseCases\Product;

use App\Models\Product;
use App\Repositories\DatabaseRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Traits\ApiResponse;
use App\UseCases\SimpleCrudUseCaseBase;

class ProductCrudUseCase extends SimpleCrudUseCaseBase
{

    use ApiResponse;

    public static function repo(): DatabaseRepositoryInterface
    {
        return new ProductRepository(new Product());
    }

    public static function render($data, string $message = '')
    {
        return static::successResponse($data, $message);
    }
}
