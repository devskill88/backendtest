<?php

namespace Tests\Feature;

use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPriceApiEndToEndTest extends TestCase
{
    use RefreshDatabase;


    protected User $user;
    protected Currency $currency1;
    protected Currency $currency2;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');

        $this->currency1 = Currency::factory()->create();
        $this->currency2 = Currency::factory()->create();

        $this->product = Product::factory()->create([
            'currency_id' => $this->currency1->id
        ]);
    }

    /** @test */
    public function no_puede_crear_precio_duplicado_para_moneda()
    {
        $this->postJson("/api/products/{$this->product->id}/prices", [
            'currency_id' => $this->currency2->id,
            'price' => 100.00
        ])->assertStatus(201);

        $response = $this->postJson("/api/products/{$this->product->id}/prices", [
            'currency_id' => $this->currency2->id,
            'price' => 200.00
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency_id']);
    }

    /** @test */
    public function eliminar_producto_elimina_sus_precios()
    {
        $this->postJson("/api/products/{$this->product->id}/prices", [
            'currency_id' => $this->currency2->id,
            'price' => 100.00
        ])->assertStatus(201);

        $this->deleteJson("/api/products/{$this->product->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('product_prices', [
            'product_id' => $this->product->id
        ]);
    }

    /** @test */
    public function no_puede_crear_precio_con_moneda_base_del_producto()
    {
        $response = $this->postJson("/api/products/{$this->product->id}/prices", [
            'currency_id' => $this->currency1->id,
            'price' => 200.00
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency_id']);
    }
}
