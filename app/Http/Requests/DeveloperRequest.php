<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'         => ['required', 'string', 'max:255'],
            'mobile'       => ['required'],
            'email'        => ['required', 'string', 'email', 'max:255'],
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $userId = $this->route('user');
            $rules['email'][] = 'unique:users,email,' . $userId;
        } else {
            $rules['email'][] = 'unique:users';
        }

        return $rules;
    }
}
