<?php

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function deleteService(Service $service)
{
    $url = route('services.destroy', $service);

    return test()->actingAsUser()->delete($url);
}

test('can delete a service', function () {
    // Arrange
    $service = Service::factory()->create();

    //Act
    $response = deleteService($service);

    //Assert
    $response->assertRedirect(route('services.index'));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito el servicio.');

    $this->assertEquals(0, Service::count());
});
