<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'password' => 'required|min:6',
            'phone' => 'required|digits:10|numeric',
            'address' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Phải nhập tên người dùng!',
            'username.required' => 'Phải nhập Username!',
            'username.unique' => 'Username đã tồn tại trong hệ thống!',
            'email.required' => 'Phải nhập Email!',
            'email.email' => 'Hãy nhập đúng định dạng Email!',
            'email.unique' => 'Email đã tồn tại trong hệ thống!',
            'password.required' => 'Phải nhập Mật khẩu!',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự!',
            'phone.required' => 'Phải nhập số điện thoại!',
            'phone.digits' => 'Hãy nhập đúng định dạng số điện thoại!',
            'phone.numeric' => 'Hãy nhập đúng định dạng số điện thoại!',
            'address.required' => 'Phải nhập Địa chỉ!',
        ];
    }
}
