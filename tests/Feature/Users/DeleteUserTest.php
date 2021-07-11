<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

uses(TestCase::class)->in('Feature');

function deleteUser(User $user)
{
    $url = route('users.destroy', $user);

    return test()->actingAsUser()->delete($url);
}

test('can delete a user', function () {
    // Arrange
    $user = User::factory()->create();

    //Act
    $response = deleteUser($user);

    //Assert
    $response->assertRedirect(route('users.index'));

    $response->assertSessionHas('flash_success', 'Se eliminó con éxito el usuario.');

    $this->assertEquals(1, User::count());
});
