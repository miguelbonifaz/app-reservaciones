<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see customer list', function () {
    // Arrange
    $url = route('customers.index');

    // Act
    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('customers.index');

    $response->assertViewHas('customers');
});
