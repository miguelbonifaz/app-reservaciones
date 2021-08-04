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
 * @property-read int|null $services_count
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public const MINUTE_INTERVALS = '30';

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

    public function workingHours($date, Service $service): Collection
    {
        $date = Carbon::createFromDate($date);

        /** @var Schedule $schedule */
        $schedule = $this->schedules()
            ->firstWhere('day', $date->dayOfWeek);

        $startTime = Carbon::createFromTimestamp($schedule->start_time)
            ->setDateFrom($date->format('Y-m-d'));

        $endTime = Carbon::createFromTimestamp($schedule->end_time)
            ->setDateFrom($date->format('Y-m-d'))
            ->subMinutes($service->duration);

        $slots = collect(CarbonInterval::minutes(self::MINUTE_INTERVALS)
            ->toPeriod(
                $startTime, $endTime
            ))
            ->map(function (Carbon $slot) use ($service, $date) {
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
                    'hour' => $slot->format('H:i'),
                    'isAvailable' => $bool ?? true
                ];
            })->reject(function ($data) use ($date) {
                $hour = explode(':', $data['hour']);
                $slot = $date->setTime($hour[0], $hour[1]);

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

                return $slot->lessThan(now());
            });

        return $slots;
    }

    public function businessDays(): Collection
    {
        return $this->schedules()
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->pluck('day');
    }
}
