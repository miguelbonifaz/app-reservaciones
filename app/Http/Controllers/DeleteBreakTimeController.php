<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteBreakTimeController extends Controller
{
    public function __invoke(Request $request)
    {
        $employee = $request->employee;

        $restSchedule = $request->restSchedule;

        $restSchedule->delete();

        return redirect()
            ->route('employees.edit', $employee)
            ->with('flash_success', 'Se eliminó con éxito la hora de descanso.');
    }
}
