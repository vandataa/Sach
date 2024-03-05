<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequest extends FormRequest
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
            'id_tp'=>'required',
            'id_qh'=>'required',
            'id_xa'=>'required',
            'price'=>'required|numeric',
        ];
    }
    public function messages(): array
    {
        return [
            'id_tp.required'=>'Bạn hãy chọn Tỉnh Thàng Phố',
            'id_qh.required'=>'Bạn hãy chọn Quận Huyện',
            'id_xa.required'=>'Bạn hãy chọn Xã Phường',
            'price.required'=>'Bạn hãy nhập phí ship',
            'price.numeric'=>'Bạn hãy nhập đúng định dạng',
        ];
    }
}
