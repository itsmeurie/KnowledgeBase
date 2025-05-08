<?php

namespace App\Http\Requests\SectionRequests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Section;

class CreateSectionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can("create", Section::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "title" => "required|string",
            "description" => "nullable|string",
            "contents" => "nullable|string",
            "parent_id" => "nullable|string",
        ];
    }
}
