<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Asantibanez\LivewireSelect\LivewireSelect;
use Illuminate\Support\Collection;

class ServiceSelect extends LivewireSelect
{
    public function getListeners()
    {
        $listeners = collect(parent::getListeners());

        $listeners->put('setServiceId', 'setServiceId');

        return $listeners->toArray();
    }

    public function options($searchTerm = null): Collection
    {
        return Service::query()
            ->searchByName($searchTerm)
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function (Service $service) {
                return [
                    'value' => $service->id,
                    'description' => $service->name,
                ];
            });
    }

    public function selectedOption($value)
    {
        $service = Service::find($value);

        return [
            'value' => optional($service)->id,
            'description' => $service
                ? $service->name
                : 'N/A',
        ];
    }
}
