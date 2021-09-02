<?php

namespace App\Models;

use App\Presenter\EmployeePresenter;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Employee
 *
 * @method static EmployeeFactory factory(...$parameters)
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereEmail($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereName($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @property string $phone
 * @method static Builder|Employee wherePhone($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * * @method static \Illuminate\Database\Eloquent\Builder|Employee searchByName($name)
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public const MINUTE_INTERVALS = '45';

    public function present(): EmployeePresenter
    {
        return new EmployeePresenter($this);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'employee_service', 'employee_id', 'service_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    public function workingHours($date, Service $service): Collection
    {
        $date = Carbon::createFromDate($date);

        $schedules = $this->schedules()
            ->where('day', $date->dayOfWeek)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->get();

        return $schedules->mapWithKeys(function (Schedule $schedule) use ($service, $date) {
            $schedule->load('location', 'rests');

            $startTime = $schedule->start_time
                ->setDateFrom($date->format('Y-m-d'));

            $endTime = $schedule->end_time
                ->setDateFrom($date->format('Y-m-d'))
                ->subMinutes($service->duration);

            $location = $schedule->location;

            return [
                $location->name => collect(CarbonInterval::minutes(self::MINUTE_INTERVALS)
                    ->toPeriod(
                        $startTime, $endTime
                    ))
                    ->reject(function (Carbon $slot) use ($schedule, $service, $date) {
                        if ($slot->lessThan(now())) {
                            return true;
                        }

                        foreach ($schedule->rests as $rest) {
                            $restHours = collect(CarbonInterval::minutes(self::MINUTE_INTERVALS)
                                ->toPeriod(
                                    $rest->start_time->setDateFrom($date),
                                    $rest->end_time->setDateFrom($date),
                                ));
                            $restHours->pop();

                            return $restHours->contains($slot);
                        }


                        if (self::MINUTE_INTERVALS == $service->duration) {
                            return false;
                        }

                        $minutes = $service->duration - self::MINUTE_INTERVALS;

                        $appointment = Appointment::query()
                            ->whereDate('date', $date)
                            ->whereTime(
                                'start_time',
                                $slot->copy()->addMinutes($minutes)
                            )
                            ->first();

                        if (!$appointment) {
                            return false;
                        }

                        return true;
                    })
                    ->map(function (Carbon $slot) use ($location, $schedule, $service, $date) {
                        $appointment = Appointment::query()
                            ->whereDate('date', $date)
                            ->where(function ($query) use ($slot) {
                                $query->whereTime('start_time', '>=', $slot);
                                $query->orWhereTime('end_time', '>=', $slot);
                            })
                            ->where(function ($query) use ($slot) {
                                $query->whereTime('start_time', '<=', $slot);
                                $query->orWhereTime('end_time', '<=', $slot);
                            })
                            ->first();

                        if ($appointment) {
                            $horasNoDisponibles = collect(CarbonInterval::minutes(self::MINUTE_INTERVALS)
                                ->toPeriod(
                                    $appointment->start_time->setDateFrom($date),
                                    $appointment->end_time->setDateFrom($date)
                                ));
                            $horasNoDisponibles->pop();

                            $bool = !$horasNoDisponibles->contains($slot);
                        }

                        return [
                            'location_id' => $location->id,
                            'hour' => $slot->format('H:i'),
                            'isAvailable' => $bool ?? true
                        ];
                    })
            ];
        });

    }

    public function businessDays(): Collection
    {
        return $this->schedules()
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->pluck('day');
    }
}
