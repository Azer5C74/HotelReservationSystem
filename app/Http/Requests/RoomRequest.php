<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'floor' => 'required|integer',
            'number' => 'required|integer',
            'name' => 'required|string|max:50',
            'is_available' => 'required|boolean',
            'hotel_id' => 'required|exists:hotels,id', // Ensure the hotel_id exists in the hotels table.
        ];
    }
}
