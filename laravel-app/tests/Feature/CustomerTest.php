<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->customerData = [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->cpf(false),
            'date_of_birth' => $this->faker->date('Y-m-d', '2002-01-31'),
            'email' => $this->faker->safeEmail(false),
            'ad_cep' => '92200-602',
            'ad_street' => $this->faker->streetName(),
            'ad_number' => $this->faker->buildingNumber(),
            'ad_comp' => $this->faker->secondaryAddress(),
            'ad_city' => $this->faker->city(),
        ];
    }

    public function test_customers_can_be_listed()
    {
        $response = $this->getJson('/api/customers');

        $response
            ->assertOk()
            ->assertJson([
                'data' => [],
            ]);
    }

    public function test_customer_can_be_created()
    {
        $response = $this->postJson('/api/customers', $this->customerData);

        $response
            ->assertCreated()
            ->assertJson([
                'data' => $this->customerData,
            ]);
    }

    public function test_invalid_customer_cannot_be_created()
    {
        $invalidCustomerData = [
            'name' => '',
            'cpf' => '11111111111',
            'date_of_birth' => '2030-01-01',
            'email' => 'whatever@.com',
            'ad_cep' => '99999',
            'ad_street' => '',
            'ad_number' => 'number',
            'ad_comp' => '',
            'ad_city' => '',
        ];

        $response = $this->postJson('/api/customers', $invalidCustomerData);

        $response
            ->assertStatus(422)
            ->assertInvalid([
                'name',
                'cpf',
                'date_of_birth',
                'email',
                'ad_cep',
                'ad_street',
                'ad_number',
                'ad_comp',
                'ad_city',
            ]);
    }

    public function test_duplicate_cpf_cannot_be_created()
    {
        $newCustomer = Customer::create($this->customerData);

        $customerData = [
            'name' => $this->faker->name(),
            'cpf' => $newCustomer->cpf,
            'date_of_birth' => $this->faker->date('Y-m-d', '2002-01-31'),
            'email' => $this->faker->safeEmail(false),
            'ad_cep' => '92200-602',
            'ad_street' => $this->faker->streetName(),
            'ad_number' => $this->faker->buildingNumber(),
            'ad_comp' => $this->faker->secondaryAddress(),
            'ad_city' => $this->faker->city(),
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $response
            ->assertStatus(422)
            ->assertInvalid([
                'cpf',
            ]);
    }

    public function test_duplicate_email_cannot_be_created()
    {
        $newCustomer = Customer::create($this->customerData);

        $customerData = [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->cpf(false),
            'date_of_birth' => $this->faker->date('Y-m-d', '2002-01-31'),
            'email' => $newCustomer->email,
            'ad_cep' => '92200-602',
            'ad_street' => $this->faker->streetName(),
            'ad_number' => $this->faker->buildingNumber(),
            'ad_comp' => $this->faker->secondaryAddress(),
            'ad_city' => $this->faker->city(),
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $response
            ->assertStatus(422)
            ->assertInvalid([
                'email',
            ]);
    }
}
