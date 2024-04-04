<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'statement'];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_services')->withPivot('rating');
    }

    public function scopeAverageRating($query, $serviceId)
    {
        $rating = DB::table('users_services')->where('service_id', $serviceId)->avg('rating');

        return number_format($rating, 2);
    }
}
