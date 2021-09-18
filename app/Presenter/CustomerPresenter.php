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
        return "{$this->customer->first_name} {$this->customer->last_name}";
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
