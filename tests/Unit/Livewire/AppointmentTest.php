<?php

use App\Http\Livewire\AppointmentReservationLivewire;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildComponent()
{
    return livewire(AppointmentReservationLivewire::class);
}

test('can get location list', function () {
    // Arrange
    $service = Service::factory()->withALocation()->create();

    $componet = buildComponent();
    $componet->set('form.service_id', $service->id);

    // Act
    $locations = $componet->get('locations');

    // Assert
    expect($locations)->toHaveCount(1);
    expect($service->locations->first()->id)->toBe($locations->first()->id);
});
