<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class BaseSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('create:user');

        User::create([
            'name' => 'Jorge',
            'email' => 'jorgeespinoza33@hotmail.com',
            'password' => bcrypt('jorgeespinoza'),
        ]);

        $employees = [
            'Master Maria Jose Jauregui',
            'Belén Illescas',
            'Carolina Coloma',
            'Chris Ruiz',
            'Cinthya Jiménez',
            'Cristina Torres',
            'Doménica Herrera',
            'Edith Castillo',
            'Emily Ponce',
            'Erika Chamaidan',
            'Gisell Ayora',
            'Jessenia Holguin',
            'Joselyn Monserrate',
            'Katherine Salazar',
            'Madeleine Jordan',
            'Maria Jose Herrera',
            'Maria Jose Illescas',
            'Sayunara Vera',
            'Tatiana Arce',
            'Cristina Alvarez',
        ];

        $urdesa = Location::create(['name' => 'Urdesa']);
        $samborondon = Location::create(['name' => 'Samborondón']);

        $servicios = [
            [
                'name' => 'Proceso diagnostico 1 (Entrevista inicial con padres)',
                'value' => 100,
            ],
            [
                'name' => 'Proceso diagnostico 2 (Evaluación)',
                'value' => 100,
            ],
            [
                'name' => 'Proceso diagnostico 3 (Devolucion de cierre con padres)',
                'value' => 100,
            ],
            [
                'name' => 'Reunión en escuela valor',
                'value' => 90,
            ],
            [
                'name' => 'Observación en escuela',
                'value' => 90,
            ],
            [
                'name' => 'Reunión con padres',
                'value' => 90,
            ],
            [
                'name' => 'Observación en casa',
                'value' => 90,
            ],
            [
                'name' => 'Reunión con profesionales externos',
                'value' => 90,
            ],
            [
                'name' => 'Intervención individual',
                'value' => 40,
            ],
            [
                'name' => 'Intervención grupal',
                'value' => 40,
            ],
            [
                'name' => 'Lúdico terapia',
                'value' => 50,
            ],
        ];

        foreach ($servicios as $service) {
            Service::create([
                'name' => $service['name'],
                'value' => $service['value'],
                'duration' => 45
            ]);
        }

        foreach ($employees as $name) {
            $employee = Employee::create([
                'name' => $name
            ]);

            $services = Service::all();

            $employee->services()->attach($services->pluck('id'));

            $this->createLocation($employee, $samborondon);

            if ($employee->name == 'Master Maria Jose Jauregui') {
                $this->createLocation($employee, $urdesa);
            }
        }

        // Creación de horarios para Maria jose Jauregui - Lunes a Viernes en Urdesa
        $start_time = [
            1 => '10:00',
            2 => '10:00',
            3 => '10:00',
            4 => '10:00',
            5 => '10:00',
        ];

        $end_time = [
            1 => '13:00',
            2 => '13:00',
            3 => '13:00',
            4 => '13:00',
            5 => '13:00',
        ];

        $employee = Employee::firstWhere('name', 'Master Maria Jose Jauregui');

        $this->createSchedule($start_time, $employee, $urdesa, $end_time);

        // Creación de horarios para Maria jose Jauregui - Lunes y Martes en Samborondon
        $start_time = [
            1 => '15:15',
            2 => '15:15',
        ];
        $end_time = [
            1 => '19:45',
            2 => '19:45',
        ];

        $this->createSchedule($start_time, $employee, $samborondon, $end_time);

        $employees = Employee::all();
        $employees = collect($employees)->reject(fn(Employee $employee) => $employee->name == 'Master Maria Jose Jauregui');

        // Creación de horario para el resto de empleados - Samborondon de Lunes a Viernes
        $start_time = [
            1 => '13:00',
            2 => '13:00',
            3 => '13:00',
            4 => '13:00',
            5 => '13:00',
        ];

        $end_time = [
            3 => '20:30',
            4 => '20:30',
            5 => '20:30',
        ];

        $employees->each(function (Employee $employee) use ($end_time, $start_time, $samborondon) {
            $this->createSchedule($start_time, $employee, $samborondon, $end_time);
        });

        // Creación de horario para el resto de empleados - Samborondon de Sábado
        $start_time = [
            6 => '09:00',
        ];

        $end_time = [
            6 => '12:45',
        ];

        $employees->each(function (Employee $employee) use ($end_time, $start_time, $samborondon) {
            $this->createSchedule($start_time, $employee, $samborondon, $end_time);
        });
    }

    public function createLocation($employee, $samborondon): void
    {
        $days = collect([0, 1, 2, 3, 4, 5, 6]);

        $days->each(function ($day) use ($samborondon, $employee) {
            $employee->schedules()->create([
                'day' => $day,
                'employee_id' => $employee->id,
                'location_id' => $samborondon->id,
            ]);
        });

        $employee->locations()->attach([$samborondon->id]);
    }

    public function createSchedule(array $start_time, $employee, $location, array $end_time): void
    {
        collect($start_time)->each(function ($hour, $day) use ($employee, $location) {
            $schedule = Schedule::query()
                ->where('day', $day)
                ->where('location_id', $location->id)
                ->where('employee_id', $employee->id)
                ->first();

            if ($hour == null) {
                $schedule->update([
                    'start_time' => null,
                ]);

                return null;
            }

            $schedule->update([
                'start_time' => $hour,
            ]);
        });

        collect($end_time)->each(function ($hour, $day) use ($employee, $location) {
            $schedule = Schedule::query()
                ->where('day', $day)
                ->where('location_id', $location->id)
                ->where('employee_id', $employee->id)
                ->first();

            if ($hour == null) {
                $schedule->update([
                    'end_time' => null,
                ]);

                return null;
            }

            $schedule->update([
                'end_time' => $hour,
            ]);
        });
    }
}
