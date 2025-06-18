<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductPrice;

class ProductPriceRepository
{
    public function index()
    {
        return ProductPrice::with(['product', 'currency'])->get();
    }

    public function getByProduct(Product $product)
    {
        return $product->prices()->with('currency')->get();
    }

    public function find($id)
    {
        return ProductPrice::with(['product', 'currency'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $product = Product::findOrFail($data['product_id']);

        if ($product->currency_id == $data['currency_id']) {
            throw new \InvalidArgumentException('La moneda debe ser diferente a la moneda base del producto');
        }

        if ($product->prices()->where('currency_id', $data['currency_id'])->exists()) {
            throw new \InvalidArgumentException('Ya existe un precio para esta moneda');
        }

        return ProductPrice::create($data);
    }

    public function update(ProductPrice $price, array $data)
    {
        if (isset($data['currency_id'])) {
            $product = $price->product;
            if ($product->currency_id == $data['currency_id']) {
                throw new \InvalidArgumentException('La moneda debe ser diferente a la moneda base del producto');
            }

            if ($product->prices()
                ->where('currency_id', $data['currency_id'])
                ->where('id', '!=', $price->id)
                ->exists()
            ) {
                throw new \InvalidArgumentException('Ya existe otro precio para esta moneda');
            }
        }

        $price->update($data);
        return $price->fresh();
    }

    public function delete(ProductPrice $price)
    {
        $price->delete();
    }
}
