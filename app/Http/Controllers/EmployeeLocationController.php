<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class EmployeeLocationController extends Controller
{
    public function index()
    {
        $location = request()->location;

        $employee = request()->employee;

        $breadcrumb = [
            [
                'title' => $employee->present()->name(),
                'url' => route('employees.edit', $employee)
            ],
            [
                'title' => 'Horario',
                'url' => ''
            ],
        ];

        $schedules = $employee->schedules()
            ->with('rests')
            ->where('location_id', $location->id)
            ->get();

        return view('employees.locations.index', [
            'schedules' => $schedules,
            'employee' => $employee,
            'location' => $location,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    public function update()
    {
        $employee = request()->employee;

        $location = request()->location;

        DB::transaction(function () use ($employee, $location) {
            collect(request()->start_time)->each(function ($hour, $day) use ($employee, $location) {
                $schedule = Schedule::query()
                    ->where('day', $day)
                    ->where('location_id', $location->id)
                    ->where('employee_id', $employee->id)
                    ->first();

                if ($hour == null) {
                    $schedule->update([
                        'start_time' => null,
                    ]);

                    return null;
                }

                $schedule->update([
                    'start_time' => $hour,
                ]);
            });

            collect(request()->end_time)->each(function ($hour, $day) use ($employee, $location) {
                $schedule = Schedule::query()
                    ->where('day', $day)
                    ->where('location_id', $location->id)
                    ->where('employee_id', $employee->id)
                    ->first();

                if ($hour == null) {
                    $schedule->update([
                        'end_time' => null,
                    ]);

                    return null;
                }

                $schedule->update([
                    'end_time' => $hour,
                ]);
            });
        });

        return redirect()
            ->route('employees.locations.index', [$employee, $location])
            ->with('flash_success', 'Se actualizó con éxito el horario');
    }
}
