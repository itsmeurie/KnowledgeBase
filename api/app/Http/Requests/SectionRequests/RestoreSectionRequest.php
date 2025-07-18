<?php

namespace App\Http\Requests\SectionRequests;
use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;

class RestoreSectionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $id = Section::hashToId($this->section);
        $section = Section::onlyTrashed()->find($id);
        return $this->user()->can("restore", $this->route("section"));
        // return $this->user()->can("restore", $this->section);
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
