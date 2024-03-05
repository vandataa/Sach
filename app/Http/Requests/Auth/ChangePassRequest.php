<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassRequest extends FormRequest
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
        return [
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'cfpassword' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'Hãy nhập Password Cũ!',
            'newpassword.required' => 'Hãy nhập Password Mới!',
            'newpassword.min' => 'Password phải từ 6 ký tự trở lên',
            'cfpassword.required' => 'Hãy nhập lại Password Mới!',
        ];
    }
}
