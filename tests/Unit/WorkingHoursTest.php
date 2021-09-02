<?php

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\RestSchedule;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('puedo obtener las horas del trabajo del empleado en un día especifico con una sola localidad', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached(Location::factory())
        ->hasAttached($service = Service::factory()->create([
            'duration' => 45
        ]))
        ->create();

    $location = Location::first();

    $schedule = $employee->schedules()
        ->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '11:30',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service);

    // Assert
    $locationName = $hours->keys()->first();

    $this->assertCount(1, $hours);
    $this->assertEquals($locationName, $location->name);

    $hours = $hours->first();
    $this->assertCount(2, $hours);
    $this->assertEquals("10:00", $hours[0]['hour']);
    $this->assertTrue($hours[0]['isAvailable']);
    $this->assertEquals("10:45", $hours[1]['hour']);
    $this->assertTrue($hours[1]['isAvailable']);
});

test('se debe descartar las horas posteriores a la hora actual', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached(Location::factory())
        ->hasAttached($service = Service::factory()->create([
            'duration' => 30
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->dayOfWeek);

    $schedule->update([
        'start_time' => now()->format('H:i'),
        'end_time' => now()->addMinutes(30)->format('H:i'),
    ]);

    // Act
    $hours = $employee->workingHours(today()->format('Y-m-d'), $service);

    // Assert
    $this->assertCount(0, $hours->first());
});

test("las horas que no esten disponible en un día, estas deben venir con el valor 'false' (servicio de 30 minutos)", function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached(Location::factory())
        ->hasAttached($service = Service::factory()->create([
            'duration' => 45
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '12:15',
    ]);

    Appointment::factory()->create([
        'service_id' => $service->id,
        'employee_id' => $employee->id,
        'date' => today()->addDay(),
        'start_time' => '10:45',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service)->values();

    // Assert
    $hours = $hours->first();

    $this->assertCount(3, $hours);

    expect('10:00')->toBe($hours[0]['hour']);
    $this->assertTrue($hours[0]['isAvailable']);

    expect('10:45')->toBe($hours[1]['hour']);
    $this->assertFalse($hours[1]['isAvailable']);

    expect('11:30')->toBe($hours[2]['hour']);
    $this->assertTrue($hours[2]['isAvailable']);
});

test("las horas que no esten disponible en un día, estas deben venir con el valor 'false' (servicio de 60 minutos)", function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached(Location::factory())
        ->hasAttached($service = Service::factory()->create([
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
        'start_time' => '10:45',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service);

    // Assert
    $hours = $hours->first()->values();

    $this->assertCount(3, $hours);

    expect('10:00')->toBe($hours[0]['hour']);
    $this->assertTrue($hours[0]['isAvailable']);

    expect('10:45')->toBe($hours[1]['hour']);
    $this->assertFalse($hours[1]['isAvailable']);

    expect('11:30')->toBe($hours[2]['hour']);
    $this->assertTrue($hours[2]['isAvailable']);
});

test('Debe filtrar las horas de trabajo si el empleado tiene horas de descanso ', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached(Location::factory())
        ->hasAttached($service = Service::factory()->create([
            'duration' => 30
        ]))
        ->create();

    $schedule = $employee->schedules()->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '13:00',
    ]);

    RestSchedule::factory()->create([
        'start_time' => '10:45',
        'end_time' => '11:30',
        'schedule_id' => $schedule->id,
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service);

    // Assert
    $hours = $hours->first()->values();

    $this->assertCount(3, $hours);

    expect('10:00')->toBe($hours[0]['hour']);
    expect('11:30')->toBe($hours[1]['hour']);
    expect('12:15')->toBe($hours[2]['hour']);
});

