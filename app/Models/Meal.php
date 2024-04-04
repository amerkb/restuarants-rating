<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name', 'image', 'active'];

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'image'.'.'.$image->extension();
        $image->move(public_path('asset/meal'), $newImageName);

        return $this->attributes['image'] = '/asset/meal/'.$newImageName;
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_meals')->withPivot('rating');
    }

    public function scopeAverageRating($query, $mealId)
    {
        $rating = DB::table('users_meals')->where('meal_id', $mealId)->avg('rating');

        return number_format($rating, 2);
    }
}
