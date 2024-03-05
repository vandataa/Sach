<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_book' => 'required|max:255',
            'description' => 'required',
            'original_price' => 'required|numeric',
            'price' => 'required|numeric',

            'id_cate' => 'required',
            'id_author' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'title_book.required' => 'Bạn không được để trống !',
            'description.required' => 'Bạn không được để trống !',
            'book_image.required' => 'Bạn không được để trống !',
            'book_image.image' => 'Ảnh sách đã tồn tại !',
            'original_price.required' => 'Bạn không được để trống !',
            'original_price.numeric' => 'Phải nhập số !',
            'price.required' => 'Bạn không được để trống !',
            'price.numeric' => 'Phải nhập số !',
            'track_qty.required' => 'Bạn không được để trống !',

            'id_cate.required' => 'Bạn không được để trống !',
            'id_author.required' => 'Bạn không được để trống !',

        ];
    }
}
