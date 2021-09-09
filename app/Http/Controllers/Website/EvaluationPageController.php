<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class EvaluationPageController extends Controller
{
    public function __invoke()
    {
        return view('website.evaluation');
    }
}
