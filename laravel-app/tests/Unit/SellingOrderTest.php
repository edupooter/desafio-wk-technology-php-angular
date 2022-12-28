<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SellingOrder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellingOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private Customer $customer;
    private DateTime $sold_at;
    private array $items = [];
    private float $total = 0;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::create([
            'name' => $this->faker->name(),
            'cpf' => $this->faker->cpf(false),
            'date_of_birth' => $this->faker->date('Y-m-d', '2002-01-01'),
            'email' => $this->faker->safeEmail(false),
            'ad_cep' => $this->faker->regexify('[0-9]{5}-[0-9]{3}'),
            'ad_street' => $this->faker->streetName(),
            'ad_number' => $this->faker->buildingNumber(),
            'ad_comp' => $this->faker->secondaryAddress(),
            'ad_city' => $this->faker->city(),
        ]);

        $this->product1 = Product::create([
            'name' => $this->faker->words(8, true),
            'amount' => $this->faker->randomFloat(2, 1, 90899.99),
        ]);

        array_push($this->items, $this->product1);

        $this->product2 = Product::create([
            'name' => $this->faker->words(6, true),
            'amount' => $this->faker->randomFloat(2, 1, 90899.99),
        ]);

        array_push($this->items, $this->product2);

        $this->sold_at = $this->faker->dateTimeBetween('-1 week', 'now');

        foreach ($this->items as $item) {
            $this->total += $item->amount;
        }
    }

    public function test_selling_order_can_be_created_on_database()
    {
        // Arrange
        $order = new SellingOrder();

        foreach ($this->items as $item) {
            $order->addProduct($item);
        }

        // Act
        $sellingOrder = SellingOrder::create([
            'sold_at' => $this->sold_at,
            'customer_id' => $this->customer->id,
            'total' => $order->getTotal(),
        ]);
        foreach ($order->getProducts() as $product) {
            $sellingOrder->products()->attach($product);
        }

        // Assert
        $this->assertEquals($this->total, $sellingOrder->total);
        $this->assertModelExists($sellingOrder);
        $this->assertDatabaseCount('selling_orders', 1);
        $this->assertDatabaseHas('selling_orders', [
            'sold_at' => $this->sold_at,
            'customer_id' => $this->customer->id,
            'total' => $this->total,
        ]);

        // N:N table (products per selling order)
        $this->assertDatabaseCount('product_selling_order', count($this->items));

        foreach ($this->items as $product) {
            $this->assertDatabaseHas('product_selling_order', [
                'product_id' => $product->id,
                'selling_order_id' => $sellingOrder->id,
            ]);
        }
    }
}
