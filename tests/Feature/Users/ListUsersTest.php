<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can see user list', function () {
    // Arrange    
    // Act
    $url = route('users.index');
    
    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();
});
