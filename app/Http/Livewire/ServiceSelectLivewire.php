<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Asantibanez\LivewireSelect\LivewireSelect;
use Illuminate\Support\Collection;

class ServiceSelectLivewire extends LivewireSelect
{
    public function options($searchTerm = null): Collection
    {
        return Service::query()
            ->orderBy('name')
            ->get()
            ->map(function (Service $service) {
                return [
                    'value' => $service->id,
                    'description' => $service->present()->name(),
                ];
            });
    }

    public function selectedOption($value): array
    {
        $service = Service::find($value);

        return [
            'value' => optional($service)->id,
            'description' => $service
                ? $service->present()->name()
                : 'N/A',
        ];
    }
}
