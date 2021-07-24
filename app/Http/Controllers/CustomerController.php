<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCreateRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()->latest()->get();

        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    public function create()
    {
        $customer = new Customer();

        return view('customers.create', [
            'customer' => $customer,
        ]);
    }

    public function store(CustomerCreateRequest $request)
    {
        Customer::create([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone,
            'identification_number' => request()->identification_number
        ]);

        return redirect()
            ->route('customers.index')
            ->with('flash_success', 'Se creó con éxito el cliente.');
    }
}
