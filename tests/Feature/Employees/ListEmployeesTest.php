<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see employee list', function () {
    // Arrange
    $url = route('employees.index');

    // Act
    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('employees.index');

    $response->assertViewHas('employees');
});
