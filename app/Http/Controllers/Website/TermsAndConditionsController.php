<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class TermsAndConditionsController extends Controller
{
    public function __invoke()
    {
        return view('website.terms-and-conditions');
    }
}
