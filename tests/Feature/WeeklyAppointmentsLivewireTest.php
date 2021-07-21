<?php

use App\Http\Livewire\WeeklyCalendarLivewire;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

uses(DatabaseTransactions::class);

function buildComponent(): TestableLivewire
{
    return Livewire::test(WeeklyCalendarLivewire::class, [
        'startingHour' => 8,
        'endingHour' => 20,
        'interval' => 15,
    ]);
}

test('can create component', function () {
    // Arrange    

    // Act
    $component = buildComponent();

    // Assert
    $this->assertNotNull($component);
});

test('can navigate to the next week', function () {
    // Arrange
    $component = buildComponent();

    // Act
    $component->call('goToNextWeek');

    //Assert
    $this->assertEquals(
        today()->addWeek(),
        $component->viewData('currentDay')
    );
});

test('can navigate to the previous week', function () {
    // Arrange
    $component = buildComponent();

    // Act    
    $component->call('goToPreviousWeek');

    //Assert
    $this->assertEquals(
        today()->subWeek(),
        $component->viewData('currentDay')
    );
});

test('can navigate to the current week from the Previous Week', function () {
    // Arrange
    $component = buildComponent();

    $component->call('goToPreviousWeek');

    // Act
    $component->call('backToCurrentWeek');

    //Assert
    $this->assertEquals(
        today(),
        $component->viewData('currentDay')
    );
});

test('can navigate to the current week from the Next Week', function () {
    // Arrange
    $component = buildComponent();

    $component->call('goToNextWeek');

    // Act
    $component->call('backToCurrentWeek');

    //Assert
    $this->assertEquals(
        today(),
        $component->viewData('currentDay')
    );
});
