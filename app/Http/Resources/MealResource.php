<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => url($this->image),
            'avg_rating' => floatval($this->averageRating($this->id)),
            'active' => boolval($this->active),
            'restaurant_id' => intval($this->restaurant_id),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
