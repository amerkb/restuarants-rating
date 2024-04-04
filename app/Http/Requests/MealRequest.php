<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
        if ($this->route('meal') === null) {
            return [
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'active' => 'sometimes|boolean',
            ];
        } else {
            return [
                'name' => 'sometimes|string',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
                'active' => 'sometimes|boolean',
            ];
        }
    }
}
