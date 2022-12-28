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

        array_push(
            $this->items,
            Product::create([
                'name' => $this->faker->words(8, true),
                'amount' => $this->faker->randomFloat(2, 1, 90899.99),
            ]),
            Product::create([
                'name' => $this->faker->words(6, true),
                'amount' => $this->faker->randomFloat(2, 1, 90899.99),
            ])
        );

        foreach ($this->items as $item) {
            $this->total += $item->amount;
        }

        $this->sold_at = $this->faker->dateTimeBetween('-1 week', 'now');
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

        // Assert N:N table (products per selling order)
        $this->assertDatabaseCount('product_selling_order', count($this->items));

        foreach ($this->items as $product) {
            $this->assertDatabaseHas('product_selling_order', [
                'product_id' => $product->id,
                'selling_order_id' => $sellingOrder->id,
            ]);
        }
    }

    public function test_selling_order_can_be_listed_on_database()
    {
        SellingOrder::create([
            'sold_at' => $this->sold_at,
            'customer_id' => $this->customer->id,
            'total' => $this->total,
        ]);

        $sellingOrder = SellingOrder::firstOrFail();

        $this->assertModelExists($sellingOrder);
        $this->assertDatabaseCount('selling_orders', 1);
    }

    public function test_selling_order_can_be_updated_on_database()
    {
        // Arrange
        $newCustomer = Customer::create([
            "name" => "Cristiana Mirella Pena",
            "cpf" => "50976206315",
            "date_of_birth" => "1994-06-05",
            "email" => "deaguiar.noeli@example.net",
            "ad_cep" => "79911-001",
            "ad_street" => "Avenida Horácio",
            "ad_number" => 98704,
            "ad_comp" => "Fundos",
            "ad_city" => "Vila Otávio"
        ]);

        $newProduct = Product::create([
            'name' => $this->faker->words(6, true),
            'amount' => $this->faker->randomFloat(2, 1, 90899.99),
        ]);

        $sellingOrder = SellingOrder::create([
            'sold_at' => $this->sold_at,
            'customer_id' => $this->customer->id,
            'total' => $this->total,
        ]);

        $newSellingOrderData = [
            'sold_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'customer_id' => $newCustomer->id,
            'total' => $newProduct->amount,
        ];

        $sellingOrder->products()->attach($newProduct);

        // Act
        $sellingOrder->update($newSellingOrderData);

        // Assert
        $this->assertModelExists($sellingOrder);
        $this->assertDatabaseHas('selling_orders', $newSellingOrderData);
        $this->assertEquals($newProduct->amount, $sellingOrder->total);

        // Assert N:N table (products per selling order)
        $this->assertDatabaseCount('product_selling_order', 1);
        $this->assertDatabaseHas('product_selling_order', [
            'product_id' => $newProduct->id,
            'selling_order_id' => $sellingOrder->id,
        ]);
    }
}
