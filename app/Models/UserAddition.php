<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddition extends Model
{
    use HasFactory;

    protected $table = 'users_additions';

    public function addition(): BelongsTo
    {
        return $this->belongsTo(Addition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
}
