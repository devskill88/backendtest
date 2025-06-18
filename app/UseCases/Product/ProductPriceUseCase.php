<?php

namespace App\UseCases\Product;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Repositories\ProductPriceRepository;

class ProductPriceUseCase
{
    public $repository;

    public function __construct()
    {
        $this->repository = new ProductPriceRepository();
    }

    public static function render($data = [], $message = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
    }

    public function getByProduct(Product $product)
    {
        return $this->repository->getByProduct($product);
    }
}
