<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use Asantibanez\LivewireSelect\LivewireSelect;
use Illuminate\Support\Collection;

class EmployeeSelect extends LivewireSelect
{
    public $service_id;

    public function getListeners()
    {
        $listeners = collect(parent::getListeners());

        $listeners->put('setEmployeeId', 'setEmployeeId');

        return $listeners->toArray();
    }

    public function setEmployeeId($data)
    {
        $employeeId = $data[0];

        $this->selectValue($employeeId);
    }

    public function afterMount($extras = [])
    {
        $this->service_id = data_get($extras, 'service_id', null);
    }

    public function options($searchTerm = null): Collection
    {
        return Employee::query()
            ->searchByName($searchTerm)
            ->when($this->hasDependency('service_id'), function ($query) {
                $query->serviceId($this->getDependingValue('service_id'));
            })
            ->limit(5)
            ->get()
            ->map(function (Employee $employee) {
                return [
                    'value' => $employee->id,
                    'description' => $employee->name,
                ];
            });

    }

    public function selectedOption($value)
    {
        $employee = Employee::find($value);

        return [
            'value' => optional($employee)->id,
            'description' => $employee
                ? $employee->name
                : 'N/A',
        ];
    }
}
