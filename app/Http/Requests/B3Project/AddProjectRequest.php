<?php

namespace App\Http\Requests\B3Project;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'registry_no' => 'required',
            'project_title' => 'required',
            'project_nature_id' => 'required',
            'project_nature_type' => 'required',
            'location' => 'required',
            'status' => 'required',
        ];
    }
}
