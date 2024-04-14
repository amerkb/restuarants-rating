<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'services.*.id' => 'required|exists:services,id',
            'services.*.rating' => 'nullable|numeric|between:0,5',
            'additions.*.id' => 'required|exists:additions,id',
            'additions.*.rating' => 'nullable|numeric|between:0,5',

        ];
    }
}
