<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required|numeric|digits:10',
            'customer_email' => 'required|email',
        ];
    }
    public function messages()
    {
        return [
            'customer_name.required' => 'Bạn không được để trống !',
            'customer_address.required' => 'Bạn không được để trống !',
            'customer_phone.required' => 'Bạn không được để trống !',
            'customer_phone.numeric' => 'Bạn cần nhập đúng định dạng số điện thoại !',
            'customer_phone.digits' => 'Bạn cần nhập đúng định dạng số điện thoại !',
            'customer_email.required' => 'Bạn không được để trống !',
            'customer_email.email' => 'Bạn cần nhập đúng định dạng email !',

        ];
    }
}
