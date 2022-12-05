<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|gt:0',
            'dateStart' => 'date',
            'dateEnd' => 'date'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => "'id' field is required",
            'id.integer' => "'id' field must be a valid integer number",
            'id.gt' => "'id' field must be greater than 0",
            'dateStart.date' => "'dateStart' field must be a valid date",
            'dateEnd.date' => "'dateEnd' field must be a valid date",
        ];
    }
}
