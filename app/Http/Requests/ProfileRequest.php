<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'         => 'required|string|max:255',
            'mobile'       => 'required|string|max:15',
            'aadhaar_no'   => 'required|string|max:20',
            'father_name'  => 'required|string|max:255',
            'mother_name'  => 'required|string|max:255',
            'state'        => 'required|string|max:255',
            'pincode'      => 'required|string|max:10',
            'full_address' => 'required|string|max:255',
        ];

        if ($this->filled('current_password')) {
            $rules['current_password'] = 'required|min:8';
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }
}
