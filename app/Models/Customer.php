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
 * @property int $id
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $name_of_child
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\CustomerFactory factory(...$parameters)
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer searchByName($name)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereFirstName($value)
 * @method static Builder|Customer whereFullName($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereLastName($value)
 * @method static Builder|Customer whereNameOfChild($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'name_of_child',
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
