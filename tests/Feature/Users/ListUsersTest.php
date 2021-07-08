<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('has users', function () {
    
    // Arrange  
    $user = \App\Models\User::factory()->create();

    // Act
    $url = route('users.index');
    
    $response = $this->actingAs($user)->get($url);    
    // Assert
    $response->assertOk();
});
