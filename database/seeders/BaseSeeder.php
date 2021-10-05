<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class BaseSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        Artisan::call('create:user');

        User::create([
            'name' => 'Jorge',
            'email' => 'jorgeespinoza33@hotmail.com',
            'password' => bcrypt('jorgeespinoza'),
        ]);

        $employees = [
            'Maria Jose Jauregui',
            'Belén Illescas',
            'Carolina Coloma',
            'Chris Ruiz',
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
                'duration' => 45,
                'value' => 100,
                'description' => 'Es la 1ra cita con papa y mama relacionada a la mecánica familiar, en esta cita se determina si el niño continua la evaluación, duración 1 hora',
                'place' => null
            ],
            [
                'name' => 'Proceso diagnostico 2 (Evaluación)',
                'duration' => 45,
                'value' => 100,
                'description' => 'Esta es la 2da cita y se realiza de manera presencial con el niño para evaluarlo mediante los diferentes metodos, duración 45 minutos',
                'place' => null
            ],
            [
                'name' => 'Proceso diagnostico 3 (Devolucion de cierre con padres)',
                'duration' => 45,
                'value' => 100,
                'description' => 'Esta es la 3ra cita para el diagnostico “en caso de haberlo”, se elabora el plan de intervención en casa, escuela y terapias individuales y grupales según la necesidad, duración 1 hora ',
                'place' => null
            ],
            [
                'name' => 'Reunión en escuela valor',
                'duration' => 60,
                'value' => 90,
                'description' => 'Reunion de nuestro equipo y padres con los profesores con el finde elaborar el plan de trabajo y adaptaciones curriculares',
                'place' => 'Escuela'
            ],
            [
                'name' => 'Observación en escuela',
                'duration' => 60,
                'value' => 90,
                'description' => 'Se realizo visita a la escuela para revisar el trabajo y el sistema de comunicación y socialización junto a la tutora',
                'place' => 'Escuela'
            ],
            [
                'name' => 'Reunión con padres',
                'duration' => 60,
                'value' => 90,
                'description' => 'Se realizan en el consultorio cada cierto tiempo cuando es necesario REEVALORAR el trabajo con los familiares',
                'place' => null
            ],
            [
                'name' => 'Observación en casa',
                'duration' => 90,
                'value' => 90,
                'description' => 'Es una observación que se da puntualmente por algún tema',
                'place' => 'Casa'
            ],
            [
                'name' => 'Reunión con profesionales externos',
                'duration' => 45,
                'value' => 90,
                'description' => 'Reuniones con psicopedagogaso terapistas de lenguaje o cualquier profesional que este trabajando con el niño',
                'place' => null
            ],
            [
                'name' => 'Intervención individual',
                'duration' => 45,
                'value' => 40,
                'description' => 'Terapia inicial en caso de requerirse como preparación a la terapia individual',
                'place' => null
            ],
            [
                'name' => 'Intervención grupal',
                'duration' => 45,
                'value' => 40,
                'description' => 'Es la terapia con niños de edad y funcionamiento similar para trabajar la comunicación, desarrollo similar, tiempos de trabajo , tolerancia a la frustración',
                'place' => null
            ],
            [
                'name' => 'Lúdico terapia',
                'duration' => 90,
                'value' => 50,
                'description' => 'Terapia en contextos naturales en diferentes parques o lugares abiertos, se trabajan frentes como motricidad, socialización con el par. ',
                'place' => 'Consultar Lugar'
            ],
        ];

        foreach ($servicios as $service) {
            $servicio = Service::factory()->create([
                'name' => $service['name'],
                'value' => $service['value'],
                'description' => $service['description'],
                'duration' => $service['duration'],
                'place' => $service['place'],
            ]);
        }

        foreach ($employees as $name) {
            $employee = Employee::create([
                'name' => $name
            ]);

            $services = Service::all();

            $employee->services()->attach($services->pluck('id'));

            $this->createLocation($employee, $samborondon);

            if ($employee->name == 'Maria Jose Jauregui') {
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

        $employee = Employee::firstWhere('name', 'Maria Jose Jauregui');

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

        $employees = Employee::all()->reject(fn(Employee $employee) => $employee->name == 'Maria Jose Jauregui');

        // Creación de horario para el resto de empleados - Samborondon de Lunes a Viernes
        $start_time = [
            1 => '13:00',
            2 => '13:00',
            3 => '13:00',
            4 => '13:00',
            5 => '13:00',
        ];

        $end_time = [
            1 => '20:30',
            2 => '20:30',
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
