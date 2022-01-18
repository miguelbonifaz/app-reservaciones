<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('can see update profile form', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $url = route('profile.edit', $user);

    $response = $this->actingAsUser()->get($url);

    // Assert
    $response->assertOk();

    $response->assertViewIs('me.edit');

    $response->assertViewHas('user');
});

test('can update my profile', function () {
    // Arrange
    $this->actingAsUser();

    $user = auth()->user();

    $url = route('profile.update', $user);

    /** @var User $data */
    $data = User::factory()->make();

    // Act
    $response = $this->actingAs($user)->post($url, [
        'name' => $data->name,
        'email' => $data->email,
        'password' => $data->password,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ]);

    // Assert
    $response->assertRedirect(route('profile.edit',$user));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito su perfil.');

    $this->assertCount(1, User::all());

    $user = User::first();

    $this->assertEquals($data->name, $user->name);
    $this->assertEquals($data->email, $user->email);
    $this->assertNotNull($user->avatar());
    $this->assertTrue(Hash::check($data->password, $user->password));
});
