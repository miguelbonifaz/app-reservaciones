<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use App\Notifications\AppointmentConfirmedNotification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $appointment = Appointment::first();
        $customer = $appointment->customer;

        $customer->notify(new AppointmentConfirmedNotification($appointment));
    }
}
