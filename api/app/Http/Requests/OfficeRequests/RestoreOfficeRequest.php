<?php

namespace App\Http\Requests\OfficeRequests;

use App\Models\Office;
use Illuminate\Foundation\Http\FormRequest;

class RestoreOfficeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $id = Office::hashToId($this->office);
        $section = Office::onlyTrashed()->find($id);
        return $this->user()->can("restore", $this->route("section"));
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
