<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::query()
            ->paginate(10);

        return view ('employees.index', [
            'employees' => $employees
        ]);
    }
}
