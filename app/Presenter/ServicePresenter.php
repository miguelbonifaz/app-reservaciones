<?php

namespace App\Presenter;

use App\Models\Service;

class ServicePresenter
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function name(): string
    {
        return $this->service->name;
    }

    public function duration(): string
    {
        return "{$this->service->duration} minutos";
    }

    public function value(): string
    {
        return "$ {$this->service->value}";
    }

}
