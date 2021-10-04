<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Employee::first()->schedules()->whereNotNull('start_time')->get()->map->day
        $this->call(BaseSeeder::class);
    }
}
