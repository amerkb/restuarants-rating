<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Addition extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name', 'active'];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_additions')->withPivot('rating');
    }

    public function scopeAverageRating($query)
    {
        $rating = DB::table('users_additions')->where('addition_id', $this->id)->avg('rating');

        return number_format($rating, 2);
    }
}
