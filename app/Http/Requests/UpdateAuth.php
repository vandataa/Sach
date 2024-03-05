<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuth extends FormRequest
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
    public function rules()
    {
        return [
            'name_author' => 'required',
            'slug' => 'required',
            'info' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'name_author.required' => 'Bạn không được để trống !',
            'slug.required' => 'Bạn không được để trống !',
            'info.required' => 'Bạn không được để trống !',
        ];
    }
}
