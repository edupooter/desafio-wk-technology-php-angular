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
        $product = Product::create([
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 999888.80)
        ]);

        $response = $this->postJson('/api/products', [
            'name' => $product->name,
            'amount' => $product->amount,
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => $product->name,
                    'amount' => $product->amount,
                ],
            ]);
    }

    public function test_product_can_be_retrieved()
    {
        $product = Product::create([
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 999888.80)
        ]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $product->name,
                    'amount' => $product->amount,
                ],
            ]);
    }

    public function test_product_can_be_updated()
    {
        $product = Product::create([
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 999888.80)
        ]);

        $productNewName = $this->faker->word(3, true);
        $productNewAmount = $this->faker->randomFloat(2, 0, 999888.80);

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => $productNewName,
            'amount' => $productNewAmount,
        ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $productNewName,
                    'amount' => $productNewAmount,
                ],
            ]);
    }

    public function test_product_can_be_deleted()
    {
        $product = Product::create([
            'name' => $this->faker->word(3, true),
            'amount' => $this->faker->randomFloat(2, 0, 999888.80)
        ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertNoContent(204);
    }
}
