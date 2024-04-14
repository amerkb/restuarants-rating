<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id ?? null,
            'name' => $this->statement ?? null,
            'available' => boolval($this->active),
            'avg_rating' => isset($this->id) ? floatval($this->averageRating($this->id)) : null,
            'created_at' => isset($this->created_at) ? $this->created_at->toDateTimeString() : null,
            'edited' => false,
        ];
    }
}
