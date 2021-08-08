<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCreateRequest;
use App\Models\Customer;
use Illuminate\Validation\Rule;

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
        ]);

        return redirect()
            ->route('customers.index')
            ->with('flash_success', 'Se creó con éxito el cliente.');
    }

    public function edit()
    {
        $customer = request()->customer;

        return view('customers.edit',[
            'customer' => $customer
        ]);
    }

    public function update()
    {
        $customer = request()->customer;

        request()->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignoreModel($customer)
            ],
            'phone' => 'required|numeric',
        ]);

        $customer->update([
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->phone,
        ]);

        return redirect()
            ->route('customers.index')
            ->with('flash_success', 'Se actualizó con éxito el cliente.');
    }

    public function destroy()
    {
        $customer = request()->customer;

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('flash_success', 'Se eliminó con éxito el cliente.');
    }
}
