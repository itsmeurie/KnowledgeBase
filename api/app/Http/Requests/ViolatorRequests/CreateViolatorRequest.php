<?php

namespace App\Http\Requests\ViolatorRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateViolatorRequest extends FormRequest
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
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'gender_id' => 'required|integer|exists:genders,id',
            // 'gender.name' => 'required_unless:gender,null|string',
        ];
    }
}
