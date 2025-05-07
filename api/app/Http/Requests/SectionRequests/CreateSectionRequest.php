<?php

namespace App\Http\Requests\SectionRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSectionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
<<<<<<< Updated upstream
        return $this->user()->can("create", $this->section);
=======
        return true;
>>>>>>> Stashed changes
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
<<<<<<< Updated upstream
            "title" => "required",
            "office_id" => "nullable",
            "file_id" => "nullable",
            "contents" => "nullable",
            "description" => "nullable",
=======
            "title" => "required|string",
            "description" => "nullable|string",
            "contents" => "nullable|string",
            "parent_id" => "nullable|string", // Ensure this matches controller logic
>>>>>>> Stashed changes
        ];
    }
}
