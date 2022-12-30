<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SellingOrder;
use Illuminate\Foundation\Testing\WithFaker;

class SellingOrderTest extends TestCase
{
    use WithFaker;

    private Customer $customer;
    private string $sold_at;
    private SellingOrder $order;
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
                'amount' => $this->faker->randomFloat(2, 0.01, 90899.99),
            ]),
            Product::create([
                'name' => $this->faker->words(4, true),
                'amount' => $this->faker->randomFloat(2, 1, 90899.99),
            ]),
            Product::create([
                'name' => $this->faker->words(2, true),
                'amount' => $this->faker->randomFloat(2, 1, 100),
            ])
        );

        foreach ($this->items as $item) {
            $this->total += (float) number_format($item->amount, 2);
        }

        $this->sold_at = $this->faker->dateTimeThisMonth('now', null)->format('Y-m-d H:i:s');

        dd($this->sold_at);

        $order = new SellingOrder();

        foreach ($this->items as $item) {
            $order->addProduct($item);
        }

        $this->order = SellingOrder::create([
            'sold_at' => $this->sold_at,
            'customer_id' => $this->customer->id,
            'total' => $order->getTotal(),
        ]);

        foreach ($order->getProducts() as $product) {
            $this->order->products()->attach($product);
        }
    }

    public function test_selling_orders_can_be_listed()
    {
        $response = $this->getJson('/api/selling-orders');

        $response
            ->assertOk()
            ->assertJson([
                'data' => [$this->order->toArray()],
            ]);
    }

    public function test_selling_order_can_be_created()
    {
        $response = $this->postJson('/api/selling-orders', $this->order->toArray());

        $response
            ->assertCreated()
            ->assertJson([
                'data' => [$this->order->toArray()],
            ]);
    }

}
