<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UpdateLocationLivewire;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateLocationLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function buildComponent(Location $location)
    {
        return Livewire::test(UpdateLocationLivewire::class, [
            'locationId' => $location->id,
        ]);
    }

    /** @test */
    public function can_create_component()
    {
        // Arrange
        $location = Location::factory()->create();

        // Act
        $component = $this->buildComponent($location);

        // Assert
        $this->assertNotNull($component);

        $component->assertSet('form.name', $location->name);
    }

    /** @test */
    public function can_update_a_location()
    {
        // Arrange
        $location = Location::factory()->create();
        $data = Location::factory()->make();

        $component = $this->buildComponent($location);
        $component->set('form.name', $data->name);

        // Act
        $component->call('updateLocation');

        // Assert
        $this->assertCount(1, Location::all());

        $this->assertEquals($data->name, $location->fresh()->name);
    }

    /** @test */
    public function fields_are_required()
    {
        // Arrange
        $location = Location::factory()->create();

        $component = $this->buildComponent($location);
        $component->set('form.name', null);

        // Act
        $component->call('updateLocation');

        // Assert
        $component->assertHasErrors('form.name');
    }
}
