<?php

use App\Http\Livewire\ShowServiceDetailLivewire;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

test('can build component', function () {
    // Arrange
    $service = Service::factory()->create();

    // Act
    $component = livewire(ShowServiceDetailLivewire::class, [
        'serviceId' => $service->id,
    ]);

    // Assert
    expect($component)->not()->toBeNull();
});
