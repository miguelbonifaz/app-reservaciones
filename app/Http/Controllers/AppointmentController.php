<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function create()
    {
        $appointment = new Appointment();

        return view('appointments.create', [
            'appointment' => $appointment,
        ]);
    }
}
