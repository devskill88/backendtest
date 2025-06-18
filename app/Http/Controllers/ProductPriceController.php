<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductPriceRequest;
use App\Http\Resources\Product\ProductPriceResource;
use App\Http\Resources\Product\ProductPriceCollection;
use App\Models\Product;
use App\UseCases\Product\ProductPriceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Product Prices
 * @authenticated
 */
class ProductPriceController extends SimpleEntityCrudController
{
    protected $useCase;
    protected $resource;

    public function __construct()
    {
        $this->useCase = new ProductPriceUseCase();
        $this->resource = ProductPriceResource::class;
    }

    public function index(): JsonResponse
    {
        return parent::index();
    }

    public function getByProduct(Product $product): JsonResponse
    {
        $prices = $this->useCase->getByProduct($product);
        return $this->useCase::render(ProductPriceResource::collection($prices));
    }

    public function store(Request $baseRequest)
    {
        $productId = $baseRequest->route('product');
        $product = Product::findOrFail($productId);

        $request = app(StoreProductPriceRequest::class);

        $request->setContainer(app())
            ->setRedirector(app('redirect'))
            ->initialize(
                $baseRequest->query->all(),
                $baseRequest->request->all(),
                $baseRequest->attributes->all(),
                $baseRequest->cookies->all(),
                $baseRequest->files->all(),
                $baseRequest->server->all(),
                $baseRequest->getContent()
            );

        $request->validateResolved();

        $validated = array_merge($request->validated(), [
            'product_id' => $product->id
        ]);

        $price = $this->useCase->repository->create($validated);

        return $this->useCase::render(
            new $this->resource($price),
            'Precio creado exitosamente'
        );
    }
}
