<?php

namespace App\Models;

use App\Presenter\ServicePresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property int $duration
 * @property float $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $description
 * @property int|null $location_id
 * @property string|null $place
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null $employees_count
 * @method static \Database\Factories\ServiceFactory factory(...$parameters)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service searchByName($name)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereDuration($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereLocationId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service wherePlaceOutsideTheOffice($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static Builder|Service whereValue($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @method static Builder|Service wherePlace($value)
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'value',
        'description',
        'place',
    ];

    public function present(): ServicePresenter
    {
        return new ServicePresenter($this);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function isIntheOffice()
    {
        if ($this->location_id) {
            return true;
        }

        return false;
    }

    public function scopeSearchByName($query, $name)
    {
        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', "%{$name}%");
        });
    }
}
