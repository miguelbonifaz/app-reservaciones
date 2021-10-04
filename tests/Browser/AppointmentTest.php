<?php

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Service;
use Database\Seeders\BaseSeeder;
use Database\Seeders\BaseSeederForTesting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

beforeEach(function () {
    $this->seed(BaseSeeder::class);
});

uses(DatabaseMigrations::class);

test('can create an appointment', function () {
    $this->browse(function (Browser $browser) {
        // Arrange
        $dataCustomer = Customer::factory()->make();

        $service = Service::first();
        $employee = Employee::first();
        $date = today()->addDays(2)->format('Y-m-d');
        $hour = '11:30';

        $browser->visit('/reservaciones')
            ->select('form.service_id', $service->id)
            ->pause('500')
            ->select('form.employee_id', $employee->id)
            ->pause('500')
            ->select('form.location_id', $employee->locations->first()->id)
            ->press('Siguiente')
            ->pause('1000')
            ->click("@date-$date")
            ->pause('1000')
            ->click("@hour-$hour")
            ->press('Siguiente')
            ->pause('500')
            ->press('Siguiente')
            ->pause('500')
            ->type('form.email', $dataCustomer->email)
            ->type('form.full_name', $dataCustomer->full_name)
            ->type('form.first_name', $dataCustomer->first_name)
            ->type('form.last_name', $dataCustomer->last_name)
            ->type('form.phone', $dataCustomer->phone)
            ->type('form.name_of_child', $dataCustomer->name_of_child)
            ->type('form.note', $note = 'This is my note')
            ->check('termsAndConditions')
            ->press('Siguiente')
            ->pause('2000')
            ->assertSee('Gracias por su reserva en linea, se le ha enviado un correo con los detalles de su reservación');

        // Assert
        expect(Customer::all())->toHaveCount(1);
        expect(Appointment::all())->toHaveCount(1);

        $customer = Customer::first();
        expect($customer->full_name)->toBe($dataCustomer->full_name);
        expect($customer->first_name)->toBe($dataCustomer->first_name);
        expect($customer->last_name)->toBe($dataCustomer->last_name);
        expect($customer->phone)->toBe($dataCustomer->phone);
        expect($customer->email)->toBe($dataCustomer->email);
        expect($customer->name_of_child)->toBe($dataCustomer->name_of_child);

        $appointment = Appointment::first();
        $location = Location::first();
        $hour = today()->setTime(explode(':', $hour)[0],explode(':', $hour)[1]);

        expect($employee->id)->toBe($appointment->employee_id);
        expect($customer->id)->toBe($appointment->customer_id);
        expect($service->id)->toBe($appointment->service_id);
        expect($location->id)->toBe($appointment->location_id);
        expect($date)->toBe($appointment->date->format('Y-m-d'));
        expect($hour->format('H:i'))->toBe($appointment->start_time->format('H:i'));
        expect(
            $hour->addMinutes($service->duration)->format('H:i')
        )->toBe($appointment->end_time->format('H:i'));
        expect($note)->toBe($appointment->note);
    });
});
