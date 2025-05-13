<?php

namespace App\Http\Resources;

use File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSectionResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            "title" => $this->title,
            "id" => $this->hash,
            "slug" => $this->slug,
            "contents" => $this->contents,
            "office" => new OfficeResource($this->whenLoaded("office")),
            "updated_at" => $this->updated_at,
            "files" => $this->files->map(function ($file) {
                return FileResource::make($file)
                    ->prevUrl(route("section.preview", ["file" => $file->hash]))
                    ->downUrl(route("section.download", ["file" => $file->hash]));
            }),
            "subsections" => $this->whenLoaded("subSections", function () {
                return $this->subSections->map(function ($section) {
                    return [
                        "title" => $section->title,
                        "id" => $section->hash,
                        "slug" => $section->slug,
                        "contents" => $section->contents,
                        "deleted_at" => $section->deleted_at,
                        "active" => is_null($section->deleted_at),
                    ];
                });
            }),
            "deleted_at" => $this->deleted_at,
            "active" => !$this->trashed(),
        ];
    }
}
