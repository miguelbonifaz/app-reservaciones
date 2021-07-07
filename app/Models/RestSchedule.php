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
 */
class RestSchedule extends Model
{
    use HasFactory;
}
