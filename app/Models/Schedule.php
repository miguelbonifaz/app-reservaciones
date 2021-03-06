<?php

namespace App\Models;

use App\Presenter\SchedulePresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property int $day
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $employee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\RestSchedule[] $rests
 * @property-read int|null $rests_count
 * @method static \Database\Factories\ScheduleFactory factory(...$parameters)
 * @method static Builder|Schedule newModelQuery()
 * @method static Builder|Schedule newQuery()
 * @method static Builder|Schedule query()
 * @method static Builder|Schedule whereCreatedAt($value)
 * @method static Builder|Schedule whereDay($value)
 * @method static Builder|Schedule whereEmployeeId($value)
 * @method static Builder|Schedule whereEndTime($value)
 * @method static Builder|Schedule whereId($value)
 * @method static Builder|Schedule whereStartTime($value)
 * @method static Builder|Schedule whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Employee $employee
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'employee_id'
    ];

    protected $casts = [
        'start_time' => 'timestamp',
        'end_time' => 'timestamp'
    ];

    public function present(): SchedulePresenter
    {
        return new SchedulePresenter($this);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function rests(): HasMany
    {
        return $this->hasMany(RestSchedule::class);
    }
}
