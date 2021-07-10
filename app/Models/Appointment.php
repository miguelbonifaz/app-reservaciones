<?php

namespace App\Models;

use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Appointment
 *
 * @method static AppointmentFactory factory(...$parameters)
 * @method static Builder|Appointment newModelQuery()
 * @method static Builder|Appointment newQuery()
 * @method static Builder|Appointment query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Appointment whereCreatedAt($value)
 * @method static Builder|Appointment whereId($value)
 * @method static Builder|Appointment whereUpdatedAt($value)
 */
class Appointment extends Model
{
    use HasFactory;
}
