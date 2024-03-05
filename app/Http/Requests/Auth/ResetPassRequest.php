<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends FormRequest
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
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Bạn hãy nhập Email!',
            'email.email' => 'Bạn hãy nhập đúng định dạng Email!',
            'email.exists' => 'Email của bạn không tồn tại trên hệ thống!',
            'password.required' => 'Bạn không được để trống Password!',
            'password.min' => 'Password phải từ 6 ký tự trở lên!',
            'password_confirm.min' => 'Password phải từ 6 ký tự trở lên!',
            'password_confirm.required' => 'Bạn hãy nhập lại Password!',
        ];
    }
}
