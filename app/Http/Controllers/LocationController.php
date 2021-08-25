<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::query()->latest()->get();

        return view('locations.index', [
            'locations' => $locations
        ]);
    }
}
