<?php

namespace App\Presenter;

use App\Models\Employee;

class EmployeePresenter
{
    public $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function name()
    {
        return $this->employee->name;
    }
    
    public function email()
    {
        return $this->employee->email;
    }

    public function phone()
    {
        return $this->employee->phone;
    }
}
