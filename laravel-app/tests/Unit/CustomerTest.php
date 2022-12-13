<?php

namespace Tests\Unit;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $customerData = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->customerData = [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->cpf(false),
            'date_of_birth' => $this->faker->date('Y-m-d', '2002-01-01'),
            'email' => $this->faker->safeEmail(false),
            'ad_cep' => $this->faker->regexify('[0-9]{5}-[\d]{3}'),
            'ad_street' => $this->faker->streetName(),
            'ad_number' => $this->faker->buildingNumber(),
            'ad_comp' => $this->faker->secondaryAddress(),
            'ad_city' => $this->faker->city(),
        ];
    }

    public function test_customer_can_be_created_on_database()
    {
        $customer = Customer::create($this->customerData);

        $this->assertModelExists($customer);
        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers', $this->customerData);
    }
}
