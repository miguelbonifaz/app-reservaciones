<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory()->create();

        Artisan::call('create:user');
    }
}
