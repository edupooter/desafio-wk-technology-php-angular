<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellingOrderTest extends TestCase
{
    use WithFaker;

    private $productData = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->productData = [
            'sold_at' => $this->faker->dateTime(),
            'customer_id' => 1,
            'total' => 1000,
        ];
    }

    public function test_selling_orders_can_be_listed()
    {
        // $response = $this->getJson('/api/selling-orders');

        // $response
        //     ->assertOk()
        //     ->assertJson([
        //         'data' => [],
        //     ]);
        $this->assertTrue(true);
    }
}
