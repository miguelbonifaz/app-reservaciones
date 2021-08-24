<?php

namespace App\Presenter;

use App\Models\Location;

class LocationPresenter
{
    public $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function name()
    {
        return $this->location->name;
    }
}
