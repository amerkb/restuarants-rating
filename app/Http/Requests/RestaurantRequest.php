<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestaurantRequest extends FormRequest
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

        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|unique:restaurants,name',
                'password' => 'required',
            ];
        }

        return [
            'name' => [
                'sometimes', 'string', Rule::unique('restaurants', 'name')->ignore($this->route('restaurant')->id),
            ],
            'password' => 'nullable',
        ];
    }
}
