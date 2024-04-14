<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone'];

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'users_restaurant');
    }
}
