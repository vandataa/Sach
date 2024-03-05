<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'phone' => 'required|digits:10|numeric',
            'address' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Phải nhập tên người dùng!',
            'phone.required' => 'Phải nhập số điện thoại!',
            'phone.digits' => 'Hãy nhập đúng định dạng số điện thoại!',
            'phone.numeric' => 'Hãy nhập đúng định dạng số điện thoại!',
            'address.required' => 'Phải nhập Địa chỉ!',
        ];
    }
}
