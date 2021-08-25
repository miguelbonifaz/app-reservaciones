<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CreateLocationLivewire;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateLocationLivewireTest extends TestCase
{
    use RefreshDatabase;

    private function buildComponent()
    {
        return Livewire::test(CreateLocationLivewire::class);
    }

    /** @test */
    public function can_create_a_location()
    {
        // Arrange
        $data = Location::factory()->make();

        $component = $this->buildComponent();
        $component->set('form.name', $data->name);

        // Act
        $component->call('createLocation');

        // Assert
        $this->assertCount(1, Location::all());

        $location = Location::first();
        $this->assertEquals($data->name, $location->name);
    }

    /** @test */
    public function fields_are_required()
    {
        // Arrange
        $data = Location::factory()->make();

        $component = $this->buildComponent();
        $component->set('form.name', null);

        // Act
        $component->call('createLocation');

        // Assert
        $component->assertHasErrors('form.name');
    }
}

