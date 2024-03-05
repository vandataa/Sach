<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MyAccountRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'. Auth::id(),
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn không được để trống Fullname!',
            'email.required' => 'Bạn không được để trống Email!',
            'email.email' => 'Bạn phải nhập đúng định dạng Email!',
            'email.unique' => 'Email của bạn đã được đăng ký rồi!',
        ];
    }
}
