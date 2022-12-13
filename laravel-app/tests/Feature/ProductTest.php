<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $productData = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->productData = [
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 99888.86),
        ];
    }

    public function test_products_can_be_listed()
    {
        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJson([
                'data' => [],
            ]);
    }

    public function test_product_can_be_created()
    {
        $response = $this->postJson('/api/products', $this->productData);

        $response
            ->assertCreated()
            ->assertJson([
                'data' => $this->productData,
            ]);
    }

    public function test_product_can_be_retrieved()
    {
        $product = Product::create($this->productData);

        $response = $this->getJson('/api/products/' . $product->id);

        $response
            ->assertOk()
            ->assertJson([
                'data' => $this->productData,
            ]);
    }

    public function test_product_can_be_updated()
    {
        $product = Product::create($this->productData);

        $productNewData = [
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 999888.80),
        ];

        $response = $this->putJson('/api/products/'.$product->id, $productNewData);

        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => $productNewData,
            ]);
    }

    public function test_product_can_be_deleted()
    {
        $product = Product::create($this->productData);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertNoContent(204);
    }
}
