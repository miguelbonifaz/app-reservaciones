<?php

namespace App\Http\Controllers;

use App\Models\User;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }
}
