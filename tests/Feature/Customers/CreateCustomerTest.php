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
        'full_name' => $data->full_name,
        'first_name' => $data->first_name,
        'last_name' => $data->last_name,
        'email' => $data->email,
        'phone' => $data->phone,
        'name_of_child' => $data->name_of_child,
    ]);

    // Assert
    $response->assertRedirect(route('customers.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el cliente.');

    $this->assertCount(1, Customer::all());

    $customer = Customer::first();

    $this->assertEquals($data->full_name, $customer->full_name);
    $this->assertEquals($data->first_name, $customer->first_name);
    $this->assertEquals($data->last_name, $customer->last_name);
    $this->assertEquals($data->email, $customer->email);
    $this->assertEquals($data->phone, $customer->phone);
    $this->assertEquals($data->name_of_child, $customer->name_of_child);
});

test('fields are required', function () {
    // Arrange

    //Act
    $response = createCustomer([
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
