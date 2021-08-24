<?php

namespace App\Models;

use App\Presenter\AppointmentPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Appointment
 *
 * @property int $id
 * @property int $customer_id
 * @property int $employee_id
 * @property int $service_id
 * @property Carbon $date
 * @property int $start_time
 * @property int $end_time
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Service $service
 * @method static \Database\Factories\AppointmentFactory factory(...$parameters)
 * @method static Builder|Appointment newModelQuery()
 * @method static Builder|Appointment newQuery()
 * @method static Builder|Appointment query()
 * @method static Builder|Appointment whereCreatedAt($value)
 * @method static Builder|Appointment whereCustomerId($value)
 * @method static Builder|Appointment whereDate($value)
 * @method static Builder|Appointment whereEmployeeId($value)
 * @method static Builder|Appointment whereEndTime($value)
 * @method static Builder|Appointment whereId($value)
 * @method static Builder|Appointment whereNote($value)
 * @method static Builder|Appointment whereStartTime($value)
 * @method static Builder|Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|Appointment whereServiceId($value)
 * @property int $location_id
 * @method static Builder|Appointment whereLocationId($value)
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'customer_id',
        'service_id',
        'location_id',
        'date',
        'start_time',
        'end_time',
        'note',
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function (self $appointment) {
            $appointment->end_time = $appointment->endTime();
        });
    }

    public function present(): AppointmentPresenter
    {
        return new AppointmentPresenter($this);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function endTime(): string
    {
        return $this->start_time->addMinutes($this->service->duration)->format('H:i');
    }
}
