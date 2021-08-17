<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class IdeHelperGeneratorCommand extends Command
{
    protected $signature = 'generate:ide-helper';

    protected $description = 'Command description';

    public function handle()
    {
        Artisan::call('ide-helper:generate');
        Artisan::call('ide-helper:meta');
        Artisan::call('ide-helper:models -W');
    }
}
