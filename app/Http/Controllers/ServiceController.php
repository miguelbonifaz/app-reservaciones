<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view ('services.index', [
            'services' => $services
        ]);
    }

    public function create()
    {
        $service = new Service();

        return view('services.create', [
            'service' => $service,
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'duration' => 'required|numeric',
        ]);

        Service::create([
            'name' => request()->name,
            'duration' => request()->duration,            
        ]);

        return redirect()
            ->route('services.index')
            ->with('flash_success', 'Se creó con éxito el servicio.');
    }
}