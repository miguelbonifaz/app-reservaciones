<?php

namespace App\Models;

use App\Presenter\ServicePresenter;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service
 *
 * @method static ServiceFactory factory(...$parameters)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $names
 * @property int $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDuration($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereNames($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @property string $name
 * @method static Builder|Service whereName($value)
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'value'
    ];

    public function present()
    {
        return new ServicePresenter($this);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_service');        
    }
}
