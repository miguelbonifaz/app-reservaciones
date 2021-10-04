<?php

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\RestSchedule;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('puedo obtener las horas del trabajo', function () {
    // Eso quiere decir que el servicio se da afuera de la oficina.

    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->hasAttached($service = Service::factory()->create(['duration' => 30]))
        ->create();

    $schedule = $employee->schedules()
        ->where('location_id', $location->id)
        ->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '11:30',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service, $location->id);

    // Assert
    $this->assertCount(3, $hours);
    expect($hours[0]['hour'])->toBe("10:00");
    expect($hours[0]['isAvailable'])->toBeTrue();
    expect($hours[1]['hour'])->toBe("10:30");
    expect($hours[1]['isAvailable'])->toBeTrue();
    expect($hours[2]['hour'])->toBe("11:00");
    expect($hours[2]['isAvailable'])->toBeTrue();
});

test('puedo obtener las horas del trabajo del empleado cuando el servicio es fuera de la oficina', function () {
    // Eso quiere decir que el servicio se da afuera de la oficina.

    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->hasAttached($service = Service::factory()->create(['duration' => 30]))
        ->create();

    $schedule = $employee->schedules()
        ->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '11:30',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service, $location->id);

    // Assert
    $this->assertCount(3, $hours);
    expect($hours[0]['hour'])->toBe("10:00");
    expect($hours[0]['isAvailable'])->toBeTrue();
    expect($hours[1]['hour'])->toBe("10:30");
    expect($hours[1]['isAvailable'])->toBeTrue();
    expect($hours[2]['hour'])->toBe("11:00");
    expect($hours[2]['isAvailable'])->toBeTrue();
});

test("las horas que no esten disponible en un día, estas deben venir con el valor 'false' (servicio de 30 minutos)", function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->hasAttached($service = Service::factory()->withALocation($location->id)->create([
            'duration' => 30
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '11:30',
    ]);

    Appointment::factory()->create([
        'service_id' => $service->id,
        'employee_id' => $employee->id,
        'date' => today()->addDay(),
        'start_time' => '10:30',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service, $location->id)->values();

    // Assert
    $this->assertCount(3, $hours);

    expect($hours[0]['hour'])->toBe('10:00');
    expect($hours[0]['isAvailable'])->toBeTrue();
    expect($hours[1]['hour'])->toBe('10:30');
    expect($hours[1]['isAvailable'])->toBeFalse();
    expect($hours[2]['hour'])->toBe('11:00');
    expect($hours[2]['isAvailable'])->toBeTrue();
});

test("las horas que no esten disponible en un día, estas deben venir con el valor 'false' (servicio de 60 minutos)", function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->hasAttached($service = Service::factory()->withALocation($location->id)->create([
            'duration' => 60
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '13:00',
    ]);

    Appointment::factory()->create([
        'service_id' => $service->id,
        'employee_id' => $employee->id,
        'date' => today()->addDay(),
        'start_time' => '11:00',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service, $location->id);

    // Assert
    $this->assertCount(3, $hours);

    expect($hours[0]['hour'])->toBe('10:00');
    expect($hours[0]['isAvailable'])->toBeTrue();
    expect($hours[1]['hour'])->toBe('11:00');
    expect($hours[1]['isAvailable'])->toBeFalse();
    expect($hours[2]['hour'])->toBe('12:00');
    expect($hours[2]['isAvailable'])->toBeTrue();
});

test('Debe filtrar las horas de trabajo si el empleado tiene horas de descanso', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($location = Location::factory()->create())
        ->hasAttached($service = Service::factory()->withALocation($location->id)->create([
            'duration' => 30
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '13:00',
    ]);

    RestSchedule::factory()->create([
        'start_time' => '11:00',
        'end_time' => '12:00',
        'schedule_id' => $schedule->id,
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service, $location->id)->values();

    // Assert
    $this->assertCount(4, $hours);

    expect($hours[0]['hour'])->toBe('10:00');
    expect($hours[0]['isAvailable'])->toBeTrue();
    expect($hours[1]['hour'])->toBe('10:30');
    expect($hours[1]['isAvailable'])->toBeTrue();
    expect($hours[2]['hour'])->toBe('12:00');
    expect($hours[2]['isAvailable'])->toBeTrue();
    expect($hours[3]['hour'])->toBe('12:30');
    expect($hours[3]['isAvailable'])->toBeTrue();
});

