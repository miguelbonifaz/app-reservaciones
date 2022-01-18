<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function deleteCustomer(Customer $customer)
{
    $url = route('customers.destroy', $customer);

    return test()->actingAsUser()->delete($url);
}

test('can delete a customer', function () {
    // Arrange
    $customer = Customer::factory()->create();

    //Act
    $response = deleteCustomer($customer);

    //Assert
    $response->assertRedirect(route('customers.index'));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito el cliente.');

    $this->assertEquals(0, Customer::count());
});
