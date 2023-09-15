<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'address' => 'required|string|max:50',
            'location' => 'required|string|max:50',
            'name' => 'required|string|max:50',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'address.required' => 'The address field is required.',
            'address.string' => 'The address field must be a string.',
            'address.max' => 'The address field cannot exceed 50 characters.',

            'location.required' => 'The location field is required.',
            'location.string' => 'The location field must be a string.',
            'location.max' => 'The location field cannot exceed 50 characters.',

            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field cannot exceed 50 characters.',
        ];
    }
}
