<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see employee list', function () {
    // Arrange
    $user = User::factory()->create();

    $url = route('employees.index');

    // Act
    $response = $this->actingAs($user)->get($url);

    // Assert
    $response->assertOk();
});