<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Restaurant extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'password', 'uuid', 'messageStatus', 'infoStatus', 'status'];

    protected $hidden = [
        'password',
    ];

    public function restaurant_details(): HasOne
    {
        return $this->hasOne(RestaurantDetail::class);
    }

    public function additions(): HasMany
    {
        return $this->hasMany(Addition::class);
    }
    public function scopeActiveAddition($query)
    {
        return $this->additions()->where('active',true)->get();
    }
    public function ratingAdditions(): HasManyThrough
    {
        return $this->hasManyThrough(UserAddition::class, Rating::class);
    }

    public function ratingServices(): HasManyThrough
    {
        return $this->hasManyThrough(UserService::class, Rating::class);
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
    public function scopeActiveServices($query)
    {
        return $this->services()->where('active',true)->get();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_restaurant');
    }

    public function scopeAvgService($query)
    {
        $services = $this->services()->get();
        $avg = 0;
        foreach ($services as $service) {
            $avg += $service->averageRating($service->id);
        }
        $avg = $avg / count($services);

        return number_format($avg, 2);

    }

    public function scopeAvgAddition($query)
    {
        $additions = $this->additions;
        $avg = 0;
        foreach ($additions as $addition) {
            $avg += $addition->averageRating();
        }
        $avg = $avg / count($additions);

        return number_format($avg, 2);

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
