<?php

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('puedo obtener las horas del trabajo del empleado en un día especifico', function () {
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create([
            'duration' => 30
        ]))
        ->create();

    $schedule = $employee->schedules()
        ->firstWhere('day', today()->addDay()->dayOfWeek);

    $schedule->update([
        'start_time' => '10:00',
        'end_time' => '11:00',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service);

    // Assert
    $this->assertCount(2, $hours);

    $this->assertEquals("10:00", $hours[0]['hour']);
    $this->assertTrue($hours[0]['isAvailable']);
    $this->assertEquals("10:30", $hours[1]['hour']);
    $this->assertTrue($hours[1]['isAvailable']);
});

test('se debe descartar las horas posteriores a la hora actual', function () {
    // Arrange
    $employee = Employee::factory()
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
    $this->assertCount(0, $hours);
});

test("las horas que no esten disponible en un día, estas deben venir con el valor 'false'", function () {
    $this->markTestSkipped('Debe solucionarse');
    // Arrange
    $employee = Employee::factory()
        ->hasAttached($service = Service::factory()->create([
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
        'start_time' => '10:00',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service);

    // Assert
    $this->assertCount(3, $hours);

    expect('10:00')->toBe($hours[0]['hour']);
    $this->assertFalse($hours[0]['isAvailable']);

    expect('10:30')->toBe($hours[1]['hour']);
    $this->assertTrue($hours[1]['isAvailable']);

    expect('11:00')->toBe($hours[2]['hour']);
    $this->assertTrue($hours[2]['isAvailable']);
});

test("Si existe un espacio ocupado, debe restarse la cantidad de minutos para que el servicio pueda ser agendado", function () {
    // Arrange
    $employee = Employee::factory()
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
        'start_time' => '11:00',
    ]);

    // Act
    $hours = $employee->workingHours(today()->addDay()->format('Y-m-d'), $service)->values();

    // Assert
    $this->assertCount(2, $hours);

    expect('10:00')->toBe($hours[0]['hour']);
    $this->assertTrue($hours[0]['isAvailable']);

    expect('12:00')->toBe($hours[1]['hour']);
    $this->assertTrue($hours[1]['isAvailable']);
});
