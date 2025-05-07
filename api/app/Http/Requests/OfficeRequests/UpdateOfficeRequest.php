<?php

namespace App\Http\Requests\OfficeRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user()->isSuperman();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "name" => "nullable",
            "code" => "nullable",
            "description" => "nullable",
        ];
    }
}
