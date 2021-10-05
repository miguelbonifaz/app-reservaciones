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
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @method static \Database\Factories\EmployeeFactory factory(...$parameters)
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereEmail($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereName($value)
 * @method static Builder|Employee wherePhone($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

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

    public function workingHours($date, Service $service, $locationId): Collection
    {
        $date = Carbon::createFromDate($date);

        /** @var Schedule $schedule */
        $schedule = $this->schedules()
            ->where('location_id', $locationId)
            ->firstWhere('day', $date->dayOfWeek);

        if (!$schedule->start_time) {
            return collect();
        }

        $startTime = $schedule->start_time
            ->setDateFrom($date->format('Y-m-d'));

        $endTime = $schedule->end_time
            ->setDateFrom($date->format('Y-m-d'))
            ->subMinutes($service->duration);

        return collect(CarbonInterval::minutes($service->duration)
            ->toPeriod(
                $startTime, $endTime
            ))
            ->reject(function (Carbon $slot) use ($schedule, $service, $date) {
                foreach ($schedule->rests as $rest) {
                    $restHours = collect(CarbonInterval::minutes($service->duration)
                        ->toPeriod(
                            $rest->start_time->setDateFrom($date),
                            $rest->end_time->setDateFrom($date),
                        ));
                    $restHours->pop();

                    return $restHours->contains($slot);
                }
            })
            ->map(function (Carbon $slot) use ($service, $date) {
                $appointments = Appointment::query()
                    ->whereDate('date', $date)
                    ->where(function ($query) use ($slot) {
                        $query->whereTime('start_time', '>=', $slot);
                    })
                    ->where(function ($query) use ($slot) {
                        $query->whereTime('start_time', '<=', $slot);
                    })
                    ->get();

                return [
                    'hour' => $slot->format('H:i'),
                    'isAvailable' => $appointments->count() < $service->slots
                ];
            });
    }

    public function businessDays(Location $location): Collection
    {
        return $this->schedules()
            ->where('location_id', $location->id)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->pluck('day');
    }
}
