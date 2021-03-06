<?php

namespace App\Models;

use App\Presenter\CustomerPresenter;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Customer
 *
 * @method static CustomerFactory factory(...$parameters)
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $identification_number
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereIdentificationNumber($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer searchByName($name)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 */
class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function present(): CustomerPresenter
    {
        return new CustomerPresenter($this);
    }

    public function scopeSearchByName($query, $name)
    {
        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', "%{$name}%");
        });
    }
}
