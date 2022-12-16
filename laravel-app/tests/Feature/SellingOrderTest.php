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
}
