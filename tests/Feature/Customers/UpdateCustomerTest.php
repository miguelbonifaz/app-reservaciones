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
        'full_name' => $data->full_name,
        'first_name' => $data->first_name,
        'last_name' => $data->last_name,
        'email' => $data->email,
        'phone' => $data->phone,
        'name_of_child' => $data->name_of_child,
    ]);

    // Assert
    $response->assertRedirect(route('customers.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el cliente.');

    $this->assertCount(1, Customer::all());

    $customer = Customer::first();

    $this->assertEquals($data->full_name, $customer->full_name);
    $this->assertEquals($data->first_name, $customer->first_name);
    $this->assertEquals($data->last_name, $customer->last_name);
    $this->assertEquals($data->last_name, $customer->last_name);
    $this->assertEquals($data->email, $customer->email);
    $this->assertEquals($data->phone, $customer->phone);
    $this->assertEquals($data->name_of_child, $customer->name_of_child);
});

test('fields are required', function () {
    // Arrange
    $customer = Customer::factory()->create();

    //Act
    $response = updateCustomer($customer,[
        'full_name' => null,
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'phone' => null,
        'name_of_child' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'full_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'name_of_child',
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

