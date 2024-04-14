<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionResource extends JsonResource
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
            //            'avg_rating' => floatval($this->averageRating($this->id)),
            'active' => boolval($this->active),
            'restaurant_id' => intval($this->restaurant_id),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
