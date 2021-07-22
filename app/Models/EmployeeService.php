<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeService
 *
 * @property int $id
 * @property int $service_id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|EmployeeService newModelQuery()
 * @method static Builder|EmployeeService newQuery()
 * @method static Builder|EmployeeService query()
 * @method static Builder|EmployeeService whereCreatedAt($value)
 * @method static Builder|EmployeeService whereEmployeeId($value)
 * @method static Builder|EmployeeService whereId($value)
 * @method static Builder|EmployeeService whereServiceId($value)
 * @method static Builder|EmployeeService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmployeeService extends Model
{
    use HasFactory;

    public $table = 'employee_service';

    protected $fillable = [
        'employee_id',
        'service_id'
    ];
}
