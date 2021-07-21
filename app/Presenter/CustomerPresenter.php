<?php

namespace App\Presenter;

use App\Models\Customer;

class CustomerPresenter
{
    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function name()
    {
        return $this->customer->name;
    }

    public function email()
    {
        return $this->customer->email;
    }
    public function phone()
    {
        return $this->customer->phone;
    }
    public function identification_number()
    {
        return $this->customer->identification_number;
    }
}
