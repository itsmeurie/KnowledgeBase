<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            "title" => $this->title,
            "id" => $this->hash,
            "description" => $this->description,
            "slug" => $this->slug,
            "contents" => $this->contents,
            "office" => OfficeResource::make($this->office),
            "subsections" => $this->subSections->map(function ($section) {
                return [
                    "title" => $section->title,
                    "id" => $section->hash,
                    "description" => $section->description,
                    "slug" => $section->slug,
                    "contents" => $section->contents,
                ];
            }),
        ];
    }
}
