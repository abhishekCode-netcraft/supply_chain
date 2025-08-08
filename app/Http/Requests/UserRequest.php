<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'account_type' => ['required'],
            'aadhaar_no'   => ['required'],
            'father_name'  => ['required'],
            'mother_name'  => ['required'],
            'state'        => ['required'],
            'pincode'      => ['required'],
            'full_address' => ['required'],
            'email'        => ['required', 'string', 'email', 'max:255'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'plain_password' => ['nullable', 'string', 'min:8'],
            'allow_sessions' => ['required', 'string'],
            'posting_rate' => ['required'],
            'show_health' => ['required'],
            'otp_feature'=>['required'],
            'data_transfer'=>['required'],
            'account_details_change_limitations'=>['required'],
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $userId = $this->route('user');
            $rules['email'][] = 'unique:users,email,' . $userId;
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            $rules['plain_password'] = ['nullable', 'string', 'min:8'];
        } else {
            $rules['email'][] = 'unique:users';
        }

        return $rules;
    }
}
