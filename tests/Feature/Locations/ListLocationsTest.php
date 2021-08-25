<?php

namespace Tests\Feature\Locations;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see locations list', function () {
    // Arrange
    Location::factory()->count(10)->create();

    $url = route('locations.index');

    // Act
    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('locations.index');

    $response->assertViewHas('locations');

    $this->assertCount(10, $response->original->locations);
});
