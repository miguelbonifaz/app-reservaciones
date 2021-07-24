<?php

namespace App\Http\Controllers;

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
}
