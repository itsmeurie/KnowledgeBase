<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViolationResource extends FormRequest
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
            'id' => $this->id,
            'name' => $this->name,
            'penalty' => $this->penalty,
            'ordinance' => $this->ordinance,
            'fine' => $this->fine,
            'created_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
