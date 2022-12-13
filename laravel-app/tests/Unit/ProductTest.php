<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $productData = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->productData = [
            'name' => 'Notebook Laravel',
            'amount' => 1200.99,
        ];
    }

    public function test_product_can_be_created_on_database()
    {
        $product = Product::create($this->productData);

        $this->assertModelExists($product);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', $this->productData);
    }

    public function test_products_can_be_listed_on_database()
    {
        $productData = [
            'name' => 'Monitor LCD',
            'amount' => 800.15,
        ];

        $product1 = Product::create($this->productData);
        $product2 = Product::create($productData);

        $this->assertModelExists($product1);
        $this->assertModelExists($product2);

        $this->assertDatabaseHas('products', $this->productData);
        $this->assertDatabaseHas('products', $productData);

        $this->assertDatabaseCount('products', 2);
    }

    public function test_product_can_be_updated_on_database()
    {
        $product = Product::create($this->productData);

        $productId = $product->id;

        $newProductData = [
            'name' => 'Notebook Octane',
            'amount' => 1500.50,
        ];

        $product->update($newProductData);

        $this->assertModelExists($product);
        $this->assertEquals($productId, $product->id);
        $this->assertDatabaseHas('products', $newProductData);
    }

    public function test_product_can_be_deleted_on_database()
    {
        $product = Product::create($this->productData);

        $this->assertModelExists($product);

        $product->delete();

        $this->assertSoftDeleted($product);
    }
}
