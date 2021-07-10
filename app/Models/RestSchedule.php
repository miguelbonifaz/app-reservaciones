<?php

namespace App\Models;

use Database\Factories\RestScheduleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RestSchedule
 *
 * @method static RestScheduleFactory factory(...$parameters)
 * @method static Builder|RestSchedule newModelQuery()
 * @method static Builder|RestSchedule newQuery()
 * @method static Builder|RestSchedule query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|RestSchedule whereCreatedAt($value)
 * @method static Builder|RestSchedule whereId($value)
 * @method static Builder|RestSchedule whereUpdatedAt($value)
 */
class RestSchedule extends Model
{
    use HasFactory;
}
