<?php

namespace App\Http\Requests\ViolatorRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateViolatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string',
            'middle_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'gender_id' => 'sometimes|required|integer|exists:genders,id',
        ];
    }
}
