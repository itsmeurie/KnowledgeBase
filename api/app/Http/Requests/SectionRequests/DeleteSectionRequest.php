<?php

namespace App\Http\Requests\SectionRequests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSectionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->can("delete", $this->route("section"));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
                //
            ];
    }
}
