<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
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
