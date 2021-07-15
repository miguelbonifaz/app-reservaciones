<?php

namespace App\Models;

use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Schedule
 *
 * @method static ScheduleFactory factory(...$parameters)
 * @method static Builder|Schedule newModelQuery()
 * @method static Builder|Schedule newQuery()
 * @method static Builder|Schedule query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Schedule whereCreatedAt($value)
 * @method static Builder|Schedule whereId($value)
 * @method static Builder|Schedule whereUpdatedAt($value)
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_time',
        'end_time'
    ];

    public function present()
    {
        return new ServicePresenter($this);
    }
}
