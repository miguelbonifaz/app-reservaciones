<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DeleteLocationFromEmployeeController extends Controller
{
    public function __invoke()
    {
        /** @var Employee $employee */
        $employee = request()->employee;

        $location = request()->location;

        DB::transaction(function () use ($location, $employee) {
            $employee->schedules()
                ->where('location_id', $location->id)
                ->delete();

            $employee->locations()->detach([$location->id]);
        });

        return redirect()
            ->route('employees.edit', $employee)
            ->with('flash_success', 'Se eliminó con éxito la localidad');
    }
}
