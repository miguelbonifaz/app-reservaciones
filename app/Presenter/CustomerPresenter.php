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

    public function name(): string
    {
        return $this->customer->name;
    }

    public function email(): string
    {
        return $this->customer->email;
    }

    public function phone(): string
    {
        return $this->customer->phone;
    }
}
