<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn không được để trống Fullname!',
            'username.required' => 'Bạn không được để trống Username!',
            'username.unique' => 'Username của bạn đã được đăng ký rồi!',
            'email.required' => 'Bạn không được để trông Email!',
            'email.email' => 'Bạn phải nhập đúng định dạng Email!',
            'email.unique' => 'Email của bạn đã được đăng ký rồi!',
            'password.required' => 'Bạn không được để trống Password!',
            'password.min' => 'Password phải từ 6 ký tự trở lên!'
        ];
    }
}
