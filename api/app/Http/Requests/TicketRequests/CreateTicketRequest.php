<?php

namespace App\Http\Requests\TicketRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
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
            'citation_number' => 'required|regex:/^\d{3}-\d{4}-\d{4}$/i',
            'violator' => 'nullable|array',
            'violator.first_name' => 'required_unless:violator,null|string',
            'violator.middle_name' => 'required_unless:violator,null|string',
            'violator.last_name' => 'required_unless:violator,null|string',
            'violator.gender_id' => 'required_unless:violator,null|exists:genders,id',
            'status' =>'required|string'
        ];
    }
}
