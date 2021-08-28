<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Models\Employee;
use App\Models\Location;
use App\Models\RestSchedule;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::query()->latest()->get();

        return view('employees.index', [
            'employees' => $employees
        ]);
    }

    public function create()
    {
        $employee = new Employee();

        $services = Service::query()->latest()->get();

        $locations = Location::query()->latest()->get();

        return view('employees.create', [
            'employee' => $employee,
            'services' => $services,
            'locations' => $locations,
        ]);
    }

    public function store(EmployeeCreateRequest $request)
    {
        DB::transaction(function () use ($request) {
            $servicesId = request()->servicesId;

            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            $employee->services()->attach($servicesId);
        });

        return redirect()
            ->route('employees.index')
            ->with('flash_success', 'Se creó con éxito el empleado.');
    }

    public function edit()
    {
        /** @var Employee $employee */
        $employee = request()->employee;

        $schedules = $employee->schedules->load('rests');

        $services = Service::query()->latest()->get();

        $locations = Location::query()->latest()->get();

        return view('employees.edit', [
            'employee' => $employee,
            'services' => $services,
            'schedules' => $schedules,
            'locations' => $locations,
        ]);
    }

    public function update()
    {
        $servicesId = request()->servicesId;

        $employee = request()->employee;

        request()->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignoreModel($employee)
            ],
            'phone' => 'required|numeric',
            'servicesId' => 'required',
        ]);

        $employee->update([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone,
        ]);

        $employee->services()->sync($servicesId);

        return redirect()
            ->route('employees.index')
            ->with('flash_success', 'Se actualizó con éxito el empleado.');
    }

    public function destroy()
    {
        $employee = request()->employee;

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('flash_success', 'Se eliminó con éxito el empleado.');
    }
}
