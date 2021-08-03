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

        $hoursNotAvailable = Appointment::query()
            ->whereDate('date', $date)
            ->get()
            ->map(function (Appointment $appointment) use ($service, $date) {
                return [
                    'start_time' => Carbon::createFromTimestamp($appointment->start_time)
                        ->setDateFrom($date->format('Y-m-d'))
                        ->subMinutes($service->duration)
                        ->addMinutes(self::MINUTE_INTERVALS),
                    'end_time' => Carbon::createFromTimestamp($appointment->end_time)
                        ->setDateFrom($date->format('Y-m-d'))
                        ->subMinutes($service->duration)
                        ->addMinutes(self::MINUTE_INTERVALS),
                ];
            });

        $slots = collect(CarbonInterval::minutes(self::MINUTE_INTERVALS)
            ->toPeriod(
                $startTime, $endTime
            ))
            ->reject(function (Carbon $slot) use ($service, $hoursNotAvailable) {

                foreach ($hoursNotAvailable as $hour) {
                    $bool = $slot->between(
                        $hour['start_time'],
                        $hour['end_time'],
                    );

                    if ($bool) {
                        return true;
                    }
                }

                return $slot->lessThan(now());
            })
            ->map(function (Carbon $slot) use ($date, $hoursNotAvailable) {
                return [
                    'hour' => $slot->format('H:i'),
                    'isAvailable' => true
                ];
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
