<?php

namespace App\Models;

use App\Presenter\AppointmentPresenter;
use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Appointment
 *
 * @method static AppointmentFactory factory(...$parameters)
 * @method static Builder|Appointment newModelQuery()
 * @method static Builder|Appointment newQuery()
 * @method static Builder|Appointment query()
 * @mixin \Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Appointment whereCreatedAt($value)
 * @method static Builder|Appointment whereId($value)
 * @method static Builder|Appointment whereUpdatedAt($value)
 * @property int $customer_id
 * @property int $employee_id
 * @property Carbon $date
 * @property int $start_time
 * @property int $end_time
 * @property string|null $note
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Employee $employee
 * @method static Builder|Appointment whereCustomerId($value)
 * @method static Builder|Appointment whereDate($value)
 * @method static Builder|Appointment whereEmployeeId($value)
 * @method static Builder|Appointment whereEndTime($value)
 * @method static Builder|Appointment whereNote($value)
 * @method static Builder|Appointment whereStartTime($value)
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'customer_id',
        'date',
        'start_time',
        'end_time',
        'note',
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'timestamp',
        'end_time' => 'timestamp',
    ];

    public function present(): AppointmentPresenter
    {
        return new AppointmentPresenter($this);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
