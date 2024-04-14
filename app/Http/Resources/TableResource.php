<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this['children']) {

            return [
                'id' => $this['idd'],
                'name' => $this['name'],
                'value' => $this['rating'],
                'date' => $this['date'],
                'userName' => $this['userName']??null,
                'userPhone' => $this['userPhone']??null,
                'note' => $this['note']??null,
                'children' => TableResource::collection($this['children']),
            ];
        }

        return [
            'id' => $this->idd,
            'name' => $this->meal->name ?? $this->service->statement,
            'value' => $this->rating,
            'date' => $this->created_at->toDateTimeString(),
        ];

    }
}
