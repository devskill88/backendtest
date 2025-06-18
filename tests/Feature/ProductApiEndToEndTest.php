<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiEndToEndTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $baseCurrency;
    protected $otherCurrency;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');

        $this->baseCurrency = Currency::factory()->create([
            'name' => 'USD',
            'symbol' => '$',
            'exchange_rate' => 1.0
        ]);

        $this->otherCurrency = Currency::factory()->create([
            'name' => 'EUR',
            'symbol' => '€',
            'exchange_rate' => 0.85
        ]);
    }

    /** @test */
    public function flujo_completo_de_producto_y_precios()
    {

        $productData = [
            'name' => 'Laptop Premium',
            'description' => 'Potente laptop para desarrolladores',
            'price' => 1200.00,
            'currency_id' => $this->baseCurrency->id,
            'tax_cost' => 120.00,
            'manufacturing_cost' => 800.00
        ];

        $createResponse = $this->postJson('/api/products', $productData);
        $createResponse->assertStatus(201);

        $productId = $createResponse->json('data.id');

        $this->assertDatabaseHas('products', [
            'id' => $productId,
            'name' => 'Laptop Premium'
        ]);

        $priceData = [
            'currency_id' => $this->otherCurrency->id,
            'price' => 1020.00
        ];

        $priceResponse = $this->postJson("/api/products/{$productId}/prices", $priceData);
        $priceResponse->assertStatus(201);

        $this->assertDatabaseHas('product_prices', [
            'product_id' => $productId,
            'currency_id' => $this->otherCurrency->id,
            'price' => 1020.00
        ]);

        $getResponse = $this->getJson("/api/products/{$productId}");
        $getResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Laptop Premium',
                    'base_price' => 1200.00
                ]
            ]);

        $pricesResponse = $this->getJson("/api/products/{$productId}/prices");
        $pricesResponse->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'price' => 1020.00,
                        'currency' => [
                            'name' => 'EUR'
                        ]
                    ]
                ]
            ]);

        $deleteResponse = $this->deleteJson("/api/products/{$productId}");
        $deleteResponse->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $productId]);
        $this->assertDatabaseMissing('product_prices', ['product_id' => $productId]);
    }

    /** @test */
    public function intentar_crear_precio_con_moneda_invalida()
    {
        $product = Product::factory()->create([
            'currency_id' => $this->baseCurrency->id
        ]);

        $response = $this->postJson("/api/products/{$product->id}/prices", [
            'currency_id' => $this->baseCurrency->id,
            'price' => 1000.00
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency_id']);
    }
}
