<?php

namespace Tests\Unit;

use App\Models\SellingOrder;
use Tests\TestCase;

class SellingOrderTest extends TestCase
{
    private $sellingOrderData = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->sellingOrderData = [
            'sold_at' => '2022-12-16 16:53:53',
            'customer_id' => 1,
            'total' => 1000,
        ];
    }

    public function test_sellingOrder_can_be_created_on_database()
    {
        $sellingOrder = SellingOrder::create($this->sellingOrderData);

        $this->assertModelExists($sellingOrder);
        $this->assertDatabaseCount('selling_orders', 1);
        $this->assertDatabaseHas('selling_orders', $this->productData);
    }
}
