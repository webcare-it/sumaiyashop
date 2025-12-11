<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropshippingProductRequest extends FormRequest
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
            'b_product_id'      => 'required|unique:products,b_product_id',
            'name'              => 'required',
            'cat_id'            => 'required|integer',
            'qty'               => 'required|integer',
            'regular_price'     => 'required',
            'product_type'      => 'required',
            'long_description'  => 'required',
            'image'             => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'gallery_image'     => 'required|array|min:1',
            'gallery_image.*'   => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gallery_image.required' => 'The gallery image field is required. You must upload at least one gallery image.',
            'gallery_image.array' => 'Gallery images must be provided as files.',
            'gallery_image.min' => 'You must upload at least one gallery image.',
            'gallery_image.*.required' => 'Each gallery image field must have an image file.',
            'gallery_image.*.image' => 'Each file must be a valid image.',
            'gallery_image.*.mimes' => 'Each image must be a file of type: jpg, jpeg, png, gif, svg, webp.',
            'gallery_image.*.max' => 'Each image must not be greater than 2048 kilobytes.',
        ];
    }
}