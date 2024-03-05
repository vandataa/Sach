<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "code" => "required|unique:sales",
            "discount" => "required|numeric",
            "count" => "numeric|required",
            "start" => "required",
            "end" => "required",
            "event" => "required",
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Bạn không được để trống !',
            'code.unique' => 'Code sale đã tồn tại !',
            'discount.required' => 'Bạn không được để trống !',
            'discount.numeric' => 'Bạn chhỉ được nhập số !',
            'count.numeric' => 'Bạn chhỉ được nhập số !',
            'count.required' => 'Bạn không được để trống !',
            'start.required' => 'Bạn không được để trống !',
            'end.required' => 'Bạn không được để trống !',
            'event.required' => 'Bạn không được để trống !',
        ];
    }
}
