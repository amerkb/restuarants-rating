<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof Restaurant) {
            return [
                'id' => $this->id,
                'uuid' => $this->uuid,
                'status' => $this->status ?? null,
                'nameCompany' => $this->restaurant_details->name ?? null,
                'categoryCompany' => $this->restaurant_details->category ?? null,
                'logoCompany' => url($this->restaurant_details->logo ?? null),
                'backgroundCompany' => url($this->restaurant_details->background ?? null),
                'additions' => AdditionResource::collection($this->additions),
                'services' => ServiceResource::collection($this->services),

            ];
        }

        return [
            'id' => $this->restaurant->id,
            'uuid' => $this->restaurant->uuid,
            'nameCompany' => $this->restaurant->name,
            'logoCompany' => url($this->logo),
            'backgroundCompany' => url($this->background),

        ];
    }
}
