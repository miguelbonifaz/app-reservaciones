<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CreateLocationLivewire;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildComponent()
{
    return livewire(CreateLocationLivewire::class);
}

test('can create a location', function () {
    // Arrange
    $data = Location::factory()->make();

    $component = buildComponent();
    $component->set('form.name', $data->name);

    // Act
    $component->call('createLocation');

    // Assert
    $this->assertCount(1, Location::all());

    $location = Location::first();
    $this->assertEquals($data->name, $location->name);
});

test('fields are required', function () {
    // Arrange
    $data = Location::factory()->make();

    $component = buildComponent();
    $component->set('form.name', null);

    // Act
    $component->call('createLocation');

    // Assert
    $component->assertHasErrors('form.name');
});
