<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'restaurant_id';

    protected $fillable = ['restaurant_id', 'name', 'category', 'logo', 'background'];

    public function setLogoAttribute($logo)
    {
        $newLogoName = uniqid().'_'.'logo'.'.'.$logo->extension();
        $logo->move(public_path('asset/logo'), $newLogoName);

        return $this->attributes['logo'] = '/asset/logo/'.$newLogoName;
    }

    public function setBackgroundAttribute($background)
    {
        $newBackgroundName = uniqid().'_'.'background'.'.'.$background->extension();
        $background->move(public_path('asset/background'), $newBackgroundName);

        return $this->attributes['background'] = '/asset/background/'.$newBackgroundName;
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
