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

    public function name()
    {
        return $this->service->name;
    }

    public function duration()
    {
        return "{$this->service->duration} minutos";
    }

}
