<?php

namespace App\Http\Requests\DupaContent;

use Illuminate\Foundation\Http\FormRequest;

class AddDupaContentRequest extends FormRequest
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
            'dupa_id' => 'required',
            'direct_unit_cost',
        ];
    }
}
