<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index', [
            'employees' => $employees
        ]);
    }

    public function create()
    {
        $employee = new Employee();

        $services = Service::all();

        return view('employees.create', [
            'employee' => $employee,
            'services' => $services,
        ]);
    }

    public function store(EmployeeCreateRequest $request)
    {
        $servicesId = request()->servicesId;

        $days = collect([0, 1, 2, 3, 4, 5, 6]);

        DB::transaction(function () use ($servicesId, $days) {
            $employee = Employee::create([
                'name' => request()->name,
                'email' => request()->email,
                'phone' => request()->phone
            ]);

            $employee->services()->attach($servicesId);

            $days->each(function ($day) use ($employee) {
                $employee->schedules()->create([
                    'day' => $day,
                    'employee_id' => $employee->id,
                ]);
            });

        });

        return redirect()
            ->route('employees.index')
            ->with('flash_success', 'Se creó con éxito el empleado.');
    }

    public function edit()
    {
        $employee = request()->employee;

        return view('employees.edit',[
            'employee' => $employee
        ]);
    }

    public function update()
    {
        $employee = request()->employee;

        request()->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignoreModel($employee)
            ],
            'phone' => 'required|numeric',
        ]);

        $employee->update([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone,

        ]);

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
