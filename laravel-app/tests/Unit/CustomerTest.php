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
            'ad_cep' => $this->faker->regexify('[0-9]{5}-[0-9]{3}'),
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

    public function test_customers_can_be_listed_on_database()
    {
        $customerData = [
            'name' => 'Carlos Chaves',
            'cpf' => '06811324260',
            'date_of_birth' => '1991-12-31',
            'email' => 'carlos-chaves@example.com',
            'ad_cep' => '91361-111',
            'ad_street' => 'Rua das Hortências',
            'ad_number' => 787,
            'ad_comp' => 'apto 1',
            'ad_city' => 'Varginha'
        ];

        $product1 = Customer::create($this->customerData);
        $product2 = Customer::create($customerData);

        $this->assertModelExists($product1);
        $this->assertModelExists($product2);

        $this->assertDatabaseHas('customers', $this->customerData);
        $this->assertDatabaseHas('customers', $customerData);

        $this->assertDatabaseCount('customers', 2);
    }

    public function test_customer_can_be_updated_on_database()
    {
        $customer = Customer::create($this->customerData);

        $customerId = $customer->id;

        $newCustomerData = [
            'name' => 'Carlos Chaves',
            'cpf' => '06811324260',
            'date_of_birth' => '1991-12-31',
            'email' => 'carlos-chaves@example.com',
            'ad_cep' => '91361-111',
            'ad_street' => 'Rua das Hortências',
            'ad_number' => 787,
            'ad_comp' => 'apto 1',
            'ad_city' => 'Varginha'
        ];

        $customer->update($newCustomerData);

        $this->assertModelExists($customer);
        $this->assertEquals($customerId, $customer->id);
        $this->assertDatabaseHas('customers', $newCustomerData);
    }

    public function test_customer_can_be_deleted_on_database()
    {
        $customer = Customer::create($this->customerData);

        $this->assertModelExists($customer);

        $customer->delete();

        $this->assertSoftDeleted($customer);
    }
}
