<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'citation_number' => $this->citation_number,
            'status' => $this->status,
            'violator' => new ViolatorResource($this->violator),
            'deleted_at' => optional($this->deleted_at)->format('F j, Y'),
            'created_at' => $this->created_at->format('F j, Y'),
        ];
    }
}
