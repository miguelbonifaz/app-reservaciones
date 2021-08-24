<?php

namespace App\Models;

use App\Presenter\LocationPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Location
 *
 * @method static \Database\Factories\LocationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @mixin \Eloquent
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function present()
    {
        return new LocationPresenter($this);
    }
}
