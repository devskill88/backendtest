<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\UseCases\Product\ProductCrudUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Products
 * @authenticated
 */
class ProductController extends SimpleEntityCrudController
{
    protected $useCase;
    protected $resource;

    public function __construct()
    {
        $this->useCase = new ProductCrudUseCase();
        $this->resource = ProductResource::class;
    }

    public function index()
    {
        return parent::index();
    }

    public function create(StoreProductRequest $request): JsonResponse
    {
        return parent::store($request);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return parent::save($request, $product);
    }

    public function remove(Request $request, Product $product)
    {
        return parent::delete($product);
    }
}
