<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createCustomer($data = [])
{
    $url = route('customers.store');

    return test()->actingAsUser()->post($url, $data);
}

test('can see create customer form', function () {

    // Arrange
    // Act
    $url = route('customers.create');

    $response = $this->actingAsUser()->get($url);
    // Assert
    $response->assertOk();

    $response->assertViewIs('customers.create');

    $response->assertViewHas('customer');
});

test('can create a customer', function () {
    // Arrange
    $data = Customer::factory()->make();

    // Act
    $response = createCustomer([
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'identification_number' => $data->identification_number
    ]);

    // Assert

    $response->assertRedirect(route('customers.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el cliente.');

    $this->assertCount(1, Customer::all());

    $customer = Customer::first();

    $this->assertEquals($data->name, $customer->name);
    $this->assertEquals($data->email, $customer->email);
    $this->assertEquals($data->phone, $customer->phone);
    $this->assertEquals($data->identification_number, $customer->identification_number);
});

test('fields are required', function () {
    // Arrange
    //Act
    $response = createCustomer([
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

test('field email must be valid', function () {
    // Arrange
    // Act
    $response = createCustomer([
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

test('phone must be number', function () {
    // Arrange
    // Act
    $response = createCustomer([
        'phone' => 'this is a number',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'phone',
    ]);
});
