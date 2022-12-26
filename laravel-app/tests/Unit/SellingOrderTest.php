<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SellingOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellingOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private Customer $customer;
    private Product $product1;
    private Product $product2;
    private array $sellingOrder = [];

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
            'name' => 'Notebook Laravel',
            'amount' => $this->faker->randomFloat(2, 1, 5500.99),
        ]);

        $this->product2 = Product::create([
            'name' => 'Cadeira Max',
            'amount' => $this->faker->randomFloat(2, 1, 5500.99),
        ]);

        $this->sellingOrder = [
            'sold_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'customer_id' => $this->customer->id,
        ];
    }

    public function test_selling_order_can_be_created_on_database()
    {
        $items = [
            $this->product1,
            $this->product2,
        ];

        $total = 0;

        foreach ($items as $item) {
            $total += $item->amount;
        }

        $sellingOrder = SellingOrder::create([
            'sold_at' => $this->sellingOrder['sold_at'],
            'customer_id' => $this->customer->id,
            'total' => $total,
        ]);

        $sellingOrder->products()->attach($this->product1);
        $sellingOrder->products()->attach($this->product2);

        $this->assertModelExists($sellingOrder);
        $this->assertDatabaseCount('selling_orders', 1);
        $this->assertDatabaseHas('selling_orders', [
            'sold_at' => $this->sellingOrder['sold_at'],
            'customer_id' => $this->customer->id,
            'total' => $total,
        ]);

        $this->assertDatabaseCount('product_selling_order', 2);
        $this->assertDatabaseHas('product_selling_order', [
            'product_id' => $this->product1->id,
            'selling_order_id' => $sellingOrder->id,
        ]);
        $this->assertDatabaseHas('product_selling_order', [
            'product_id' => $this->product2->id,
            'selling_order_id' => $sellingOrder->id,
        ]);
    }
}
