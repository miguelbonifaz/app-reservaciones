<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Employee
 *
 * @method static EmployeeFactory factory(...$parameters)
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
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

    public function present()
    {
        return new UserPresenter($this);
    }
}
