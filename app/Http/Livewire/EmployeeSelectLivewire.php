<?php

namespace App\Http\Livewire;

use App\Models\Employee;
use App\Models\Service;
use Asantibanez\LivewireSelect\LivewireSelect;
use Illuminate\Support\Collection;

class EmployeeSelectLivewire extends LivewireSelect
{
    public function options($searchTerm = null): Collection
    {
        $serviceId = $this->getDependingValue('form.service_id');

        $this->emit('refreshEmployee');
        if (!$serviceId) {
            return collect();
        }

        return Service::find($serviceId)
            ->employees()
            ->orderBy('name')
            ->get()
            ->map(function (Employee $employee) {
                return [
                    'value' => $employee->id,
                    'description' => $employee->present()->name(),
                ];
            });
    }

    public function selectedOption($value): array
    {
        $employee = Employee::find($value);

        return [
            'value' => optional($employee)->id,
            'description' => $employee
                ? $employee->present()->name()
                : 'N/A',
        ];
    }
}
