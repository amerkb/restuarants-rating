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
            'id' => $this->idd ?? null,
            'idReal' => $this->id,
            'name' => $this->name,
            'available' => boolval($this->active),
            'avg_rating' => floatval($this->averageRating()),
            'edited' => false,

        ];
    }
}
