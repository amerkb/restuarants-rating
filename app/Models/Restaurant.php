<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Restaurant extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'password', 'uuid'];

    protected $hidden = [
        'password',
    ];

    public function restaurant_details(): HasOne
    {
        return $this->hasOne(RestaurantDetail::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
