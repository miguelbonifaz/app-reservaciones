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
            'full_name' => request()->full_name,
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'email' => request()->email,
            'phone' => request()->phone,
            'name_of_child' => request()->name_of_child,
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
            'full_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignoreModel($customer)
            ],
            'phone' => 'required|numeric',
            'name_of_child' => 'required'
        ]);

        $customer->update([
            'full_name' => request()->full_name,
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'email' => request()->email,
            'phone' => request()->phone,
            'name_of_child' => request()->name_of_child,
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
