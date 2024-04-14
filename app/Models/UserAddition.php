<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddition extends Model
{
    protected $table = 'users_meals';

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Addition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
