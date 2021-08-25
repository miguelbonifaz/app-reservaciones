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

test('can create component', function () {
    // Arrange

    // Act
    $component = buildComponent();

    // Assert
    $this->assertNotNull($component);
});
