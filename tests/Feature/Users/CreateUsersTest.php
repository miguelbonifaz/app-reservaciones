<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function createUser($data = [])
{
    $user = User::factory()->create();

    $url = route('users.store');

    return test()->actingAs($user)->post($url, $data);
}

test('can see create user form', function () {

    // Arrange
    $user = User::factory()->create();

    // Act
    $url = route('users.create');

    $response = $this->actingAs($user)->get($url);
    // Assert
    $response->assertOk();

    $response->assertViewIs('users.create');

    $response->assertViewHas('user');
});

test('can create a user', function () {

    // Arrange
    $data = User::factory()->make();

    // Act
    $response = createUser([
        'name' => $data->name,
        'email' => $data->email,
        'password' => $data->password,
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ]);

    // Assert

    $response->assertRedirect(route('users.index'));

    $response->assertSessionHas('flash_success', 'Se creó con éxito el usuario.');

    $this->assertCount(2, User::all());

    $user = User::firstWhere('email', $data->email);

    $this->assertEquals($data->name, $user->name);
    $this->assertEquals($data->email, $user->email);
    $this->assertNotNull($user->avatar());
});

test('fields are required', function () {
    // Arrange
    //Act
    $response = createUser([
        'name' => null,
        'email' => null,
        'password' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'email',
        'password',
    ]);
});

test('field email must be valid', function () {
    // Arrange
    // Act
    $response = createUser([
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

test('email must be unique', function () {
    // Arrange
    /** @var User $user */
    $user = User::factory()->create();

    // Act
    $response = createUser([
        'email' => $user->email,
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});
