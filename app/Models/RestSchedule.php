<?php

namespace App\Models;

use Database\Factories\RestScheduleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\RestSchedule
 *
 * @method static RestScheduleFactory factory(...$parameters)
 * @method static Builder|RestSchedule newModelQuery()
 * @method static Builder|RestSchedule newQuery()
 * @method static Builder|RestSchedule query()
 * @mixin \Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RestSchedule whereCreatedAt($value)
 * @method static Builder|RestSchedule whereId($value)
 * @method static Builder|RestSchedule whereUpdatedAt($value)
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $schedule_id
 * @method static Builder|RestSchedule whereEndTime($value)
 * @method static Builder|RestSchedule whereScheduleId($value)
 * @method static Builder|RestSchedule whereStartTime($value)
 */
class RestSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'schedule_id'
    ];

    protected $casts = [
        'start_time' => 'timestamp',
        'end_time' => 'timestamp'
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
