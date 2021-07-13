<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function __invoke()
    {
        seo()
            ->title('Psicóloga María José Jáuregui')
            ->description('Máster en Autismo e Intervención Psicoeducativa Terapista de comunicación y socialización');

        return view('website.home');
    }
}
