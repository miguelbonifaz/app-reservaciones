<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function updateUser(User $user,$data = [])
{
    $logedUser = \App\Models\User::factory()->create();

    $url = route('users.update',$user);

    return test()->actingAs($logedUser)->post($url, $data);
}

test('can see update user form', function () {
    
    // Arrange
    $logedUser = \App\Models\User::factory()->create();

    $user = \App\Models\User::factory()->create();

    // Act
    $url = route('users.edit', $user);

    $response = $this->actingAs($logedUser)->get($url);
    // Assert
    $response->assertOk();

    $response->assertViewIs('users.edit');

    $response->assertViewHas('user');
});

test('can update an user', function () {
    
    // Arrange      
    $user = \App\Models\User::factory()->create();

    $data = \App\Models\User::factory()->make();

    // Act

    $response = updateUser($user,[
        'name' => $data->name,
        'email' => $data->email,
        'password' => $data->password,
        'avatar' => Illuminate\Http\UploadedFile::fake()->image('avatar.jpg'),        
    ]);

    // Assert

    $response->assertRedirect(route('users.index'));

    $response->assertSessionHas('flash_success', 'Se actualizó con éxito el usuario.');

    $this->assertCount(2, User::all());

    $user = User::firstWhere('email', $data->email);

    $this->assertEquals($data->name, $user->name);
    $this->assertEquals($data->email, $user->email);
    $this->assertNotNull($user->avatar());
});

test('fields are required', function () {
    // Arrange
    $user = \App\Models\User::factory()->create(); 
    //Act
    $response = updateUser($user,[
        'name' => null,
        'email' => null,
    ]);

    //Assert
    $response->assertSessionHasErrors([
        'name',
        'email',
    ]);
});

test('field email must be valid', function () {
    // Arrange
    $user = \App\Models\User::factory()->create();
    // Act
    $response =  updateUser($user,[
        'email' => 'not-email',
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'email',
    ]);
});

test('can delete the profile picture', function () {
    
    // Arrange  
    $logedUser = \App\Models\User::factory()->create();
    
    $user = \App\Models\User::factory()->create();

    $user->saveAvatar(Illuminate\Http\UploadedFile::fake()->image('avatar.jpg'));

    $this->assertNotNull($user->avatar());

    $url = route('users.remove', [$user]);

    //Act
    $response = $this->actingAs($logedUser)->post($url);
    
    //Assert
    $response->assertRedirect(route('users.edit',$user));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito la foto.');

    $this->assertNull($user->fresh()->getFirstMedia('avatar'));
});
