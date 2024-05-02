<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent=0;
        if (Auth::check()) {
        $parent = Auth::user()->parentService;
    }
        if (isset($this->children) && count($this->children) > 0) {
            return [
                'id' => $this->idd ?? null,
                'idReal' => $this->id ?? null,
                'name' => $this->statement ?? null,
                'available' => boolval($this->active),
                'avg_rating' => isset($this->id) ? floatval($this->averageRating($this->id)) : null,
                'created_at' => isset($this->created_at) ? $this->created_at->toDateTimeString() : null,
                'edited' => false,
                'parent' => $this->id == $parent ? true : false,
//                'children' => ServiceResource::collection($this->children),
            ];
        } else {
            return [
                'id' => $this->idd ?? null,
                'idReal' => $this->id ?? null,
                'name' => $this->statement ?? null,
                'available' => boolval($this->active),
                'avg_rating' => isset($this->id) ? floatval($this->averageRating($this->id)) : null,
                'created_at' => isset($this->created_at) ? $this->created_at->toDateTimeString() : null,
                'parent' => $this->id == $parent ? true : false,
                'edited' => false,
            ];
        }
    }
}
