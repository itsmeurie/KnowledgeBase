<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource {
    protected $_prevUrl = null;
    protected $_downUrl = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            "id" => $this->hash,
            "name" => $this->name,
            "mime" => $this->mime,
            "size" => $this->size,
            "ext" => $this->ext,
            "prevUrl" => $this->when($this->_prevUrl, $this->_prevUrl),
            "downUrl" => $this->when($this->_downUrl, $this->_downUrl),
        ];
    }

    public function prevUrl(string $prevUrl) {
        $this->_prevUrl = $prevUrl;
        return $this;
    }
    public function downUrl(string $downUrl) {
        $this->_downUrl = $downUrl;
        return $this;
    }
}
