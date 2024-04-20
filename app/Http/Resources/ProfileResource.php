<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'messageStatus' => boolval($this->messageStatus) ?? null,
            'branchCompany' => $this->branch->name ?? null,
            'categoryCompany' => $this->restaurant_details->category ?? null,
            'phoneCompany' => $this->restaurant_details->phone ?? null,
            'emailCompany' => $this->restaurant_details->email ?? null,
            'startMessageCompany' => $this->restaurant_details->startMessage ?? null,
            'endMessageCompany' => $this->restaurant_details->endMessage ?? null,
            'logoCompany' => url($this->restaurant_details->logo ?? null),
            'backgroundCompany' => url($this->restaurant_details->background ?? null),

        ];

    }
}
