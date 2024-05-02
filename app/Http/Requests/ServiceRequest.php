<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
                'statement' => 'required|string',
                'active' => 'sometimes|bool',
                'isChildren' => 'sometimes|bool',
            ];
        } else {
            return [
                'statement' => 'sometimes|string',
                'active' => 'sometimes|bool',
            ];
        }
    }

    public function validationData(): array
    {
        $data = $this->all();

        if ($this->isMethod('post') && ! isset($data['active'])) {
            $data['active'] = true;
        }

        return $data;
    }
}
