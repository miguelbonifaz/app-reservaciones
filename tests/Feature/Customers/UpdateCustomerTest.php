<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDataBase::class);

function updateCustomer(Customer $customer ,$data = [])
{
    $url = route('customers.update' ,$customer);

    return test()->actingAsUser()->post($url, $data);
}

test('can see update customer form', function () {

    // Arrange
    $customer = Customer::factory()->create();
    // Act
    $url = route('customers.edit', $customer);

    $response = $this->actingAsUser()->get($url);
    // Assert
    $response->assertOk();

    $response->assertViewIs('customers.edit');

    $response->assertViewHas('customer');
});

test('can update an customer', function () {

    // Arrange
    $customer = Customer::factory()->create();

    $data = Customer::factory()->make();

    // Act
    $response = updateCustomer($customer,[
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'identification_number' => $data->identification_number
    ]);

    // Assert
    $response->assertRedirect(route('customers.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el cliente.');

    $this->assertCount(1, Customer::all());

    $customer = Customer::first();

    $this->assertEquals($data->name, $customer->name);
    $this->assertEquals($data->email, $customer->email);
    $this->assertEquals($data->phone, $customer->phone);
    $this->assertEquals($data->identification_number, $customer->identification_number);

});

test('fields are required', function () {
    // Arrange
    $customer = Customer::factory()->create();
    //Act
    $response = updateCustomer($customer,[
        'name' => null,
        'email' => null,
        'phone' => null,
        'identification_number' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'email',
        'phone',
        'identification_number'
    ]);
});

test('field phone must be a number', function () {
    // Arrange
    $customer = Customer::factory()->create();

    // Act
    $response = updateCustomer($customer,[
        'phone' => 'phone Number String',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'phone',
    ]);
});

test('field email must be valid', function () {
    // Arrange
    $customer = Customer::factory()->create();

    // Act
    $response = updateCustomer($customer,[
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

