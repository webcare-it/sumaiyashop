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
            'gallery_image'     => 'array',
            'gallery_image.*'   => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if gallery_image array has any files uploaded
            $galleryImages = $this->file('gallery_image');
            
            if (empty($galleryImages) || !is_array($galleryImages)) {
                $validator->errors()->add('gallery_image', 'The gallery image field is required. You must upload at least one gallery image.');
            } else {
                // Check if all files in the array are empty
                $hasValidFile = false;
                foreach ($galleryImages as $file) {
                    if ($file && $file->isValid()) {
                        $hasValidFile = true;
                        break;
                    }
                }
                
                if (!$hasValidFile) {
                    $validator->errors()->add('gallery_image', 'The gallery image field is required. You must upload at least one gallery image.');
                }
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gallery_image.*.image' => 'Each file must be a valid image.',
            'gallery_image.*.mimes' => 'Each image must be a file of type: jpg, jpeg, png, gif, svg, webp.',
            'gallery_image.*.max' => 'Each image must not be greater than 2048 kilobytes.',
        ];
    }
}