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
                'infoStatus' => boolval($this->infoStatus) ?? null,
                'messageStatus' => boolval($this->messageStatus) ?? null,
                'additionalStatus' => boolval($this->additionalStatus) ?? null,
                'nameCompany' => $this->restaurant_details->name ?? null,
                'branchCompany' => $this->branch->name ?? null,
                'categoryCompany' => $this->restaurant_details->category ?? null,
                'phoneCompany' => $this->restaurant_details->phone ?? null,
                'emailCompany' => $this->restaurant_details->email ?? null,
                'startMessageCompany' => $this->restaurant_details->startMessage ?? null,
                'endMessageCompany' => $this->restaurant_details->endMessage ?? null,
                'logoCompany' => url($this->restaurant_details->logo ?? null),
                'backgroundCompany' => url($this->restaurant_details->background ?? null),
                'additions' => ServiceResource::collection($this->activeServicesSub()),
                'services' => ServiceResource::collection($this->activeServices()),

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
