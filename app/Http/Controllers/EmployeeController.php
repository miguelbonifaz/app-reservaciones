<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view ('employees.index', [
            'employees' => $employees
        ]);
    }

    public function create()
    {
        $employee = new Employee();

        return view('employees.create', [
            'employee' => $employee,
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|numeric',
        ]);

        Employee::create([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone
        ]);

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
            'email' => 'required|email',
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
