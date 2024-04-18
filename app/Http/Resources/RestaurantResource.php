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
                'infoStatus' => boolval($this->status) ?? null,
                'nameCompany' => $this->restaurant_details->name ?? null,
                'branchCompany' => $this->branch->name ?? null,
                'categoryCompany' => $this->restaurant_details->category ?? null,
                'phoneCompany' => $this->restaurant_details->phone,
                'emailCompany' => $this->restaurant_details->email,
                'startMessageCompany' => $this->restaurant_details->startMessage,
                'endMessageCompany' => $this->restaurant_details->endMessage,
                'logoCompany' => url($this->restaurant_details->logo ?? null),
                'backgroundCompany' => url($this->restaurant_details->background ?? null),
                'additions' => AdditionResource::collection($this->additions),
                'services' => ServiceResource::collection($this->services),

            ];
        }

        return [

            'logoCompany' => url($this->logo),
            'backgroundCompany' => url($this->background),
            'phoneCompany' => $this->phone,
            'emailCompany' => $this->email,
            'startMessageCompany' => $this->startMessage,
            'endMessageCompany' => $this->endMessage,

        ];
    }
}
