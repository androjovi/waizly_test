<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code_product' => 'required|unique:product,code_product,'. $this->id,
            'name_product' => 'required',
            'description_product' => 'required',
            'price_product' => 'required',
            'image_product' => 'required',
        ];
    }
}
