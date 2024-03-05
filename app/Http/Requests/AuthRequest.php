<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_author' => 'required|unique:authors',
            'author_image' => 'required|unique:authors',
            'slug' => 'required|unique:authors',
            'info' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'name_author.required' => 'Bạn không được để trống !',
            'name_author.unique' => 'Tên tác giả đã tồn tại !',
            'author_image.required' => 'Bạn không được để trống !',
            'author_image.unique' => 'Ảnh tác giả đã tồn tại !',
            'slug.required' => 'Bạn không được để trống !',
            'slug.unique' => 'Slug này đã tồn tại !',
            'info.required' => 'Bạn không được để trống !',
        ];
    }
}
