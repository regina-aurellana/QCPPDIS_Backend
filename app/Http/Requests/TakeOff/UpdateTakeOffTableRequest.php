<?php

namespace App\Http\Requests\TakeOff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTakeOffTableRequest extends FormRequest
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
            'take_off_id' => 'required',
            'sow_category_id' => 'required',
            'dupa_id' => 'required',
            'table_row_result_field_id' => 'required',
        ];
    }
}
