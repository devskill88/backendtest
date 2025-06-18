<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $currencies = Currency::all();

        $products->each(function ($product) use ($currencies) {
            $currencies->each(function ($currency) use ($product) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'currency_id' => $currency->id,
                    'price' => $product->price * $currency->exchange_rate,
                ]);
            });
        });
    }
}
