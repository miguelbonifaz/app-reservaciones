<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see service list', function () {
    
    // Arrange
    $url = route('services.index');

    // Act
    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('services.index');

    $response->assertViewHas('services');
});
