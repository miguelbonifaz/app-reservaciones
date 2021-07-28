<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Asantibanez\LivewireSelect\LivewireSelect;
use Illuminate\Support\Collection;

class CustomerSelect extends LivewireSelect
{
    public function options($searchTerm = null): Collection
    {
        return Customer::query()
            ->searchByName($searchTerm)
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function (Customer $customer) {
                return [
                    'value' => $customer->id,
                    'description' => $customer->present()->name(),
                ];
            });
    }

    public function selectedOption($value)
    {
        $customer = Customer::find($value);

        return [
            'value' => optional($customer)->id,
            'description' => $customer
                ? $customer->present()->name()
                : 'N/A',
        ];

    }


}
