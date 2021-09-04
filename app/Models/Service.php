<?php

namespace App\Models;

use App\Presenter\ServicePresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Service
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $duration
 * @property float $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null $employees_count
 * @method static \Database\Factories\ServiceFactory factory(...$parameters)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service searchByName($name)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDuration($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static Builder|Service whereValue($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'value',
        'description'
    ];

    public function present(): ServicePresenter
    {
        return new ServicePresenter($this);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function scopeSearchByName($query, $name)
    {
        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', "%{$name}%");
        });
    }
}
