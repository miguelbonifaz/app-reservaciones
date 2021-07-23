<?php

use App\Http\Livewire\CreateBreakTimeLivewire;
use App\Models\Employee;
use App\Models\RestSchedule;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Testing\TestableLivewire;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

function buildComponent(Schedule $schedule): TestableLivewire
{
    test()->actingAsUser();

    return livewire(CreateBreakTimeLivewire::class, [
        'scheduleId' => $schedule->id
    ]);
}

test('can create component', function () {
    // Arrange
    Employee::factory()->create();
    $schedule = Schedule::first();

    // Act
    $component = buildComponent($schedule);

    // Assert
    $component->assertSet('scheduleId', $schedule->id);
    $this->assertNotNull($component);
});

test('can create a break time', function () {
    // Arrange
    Employee::factory()->create();
    $schedule = Schedule::first();

    $component = buildComponent($schedule);
    $component->set('startTime', $startTime = '10:00');
    $component->set('endTime', $endTime = '11:00');

    // Act
    $component->call('createBreakTime');

    // Assert
    $this->assertCount(1, RestSchedule::all());

    $rest = RestSchedule::first();
    expect($schedule->id)->toEqual($rest->schedule_id);
    expect($startTime)->toEqual(
        Carbon::createFromTimestamp($rest->start_time)->format('H:i')
    );
    expect($endTime)->toEqual(
        Carbon::createFromTimestamp($rest->end_time)->format('H:i')
    );
});
