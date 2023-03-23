<?php

namespace App\Http\Requests\Dupa;

use Illuminate\Foundation\Http\FormRequest;

class AddDupaRequest extends FormRequest
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
            'subcategory_id' => 'required',
            'item_number' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'unit_cost' => 'required',
        ];
    }
}