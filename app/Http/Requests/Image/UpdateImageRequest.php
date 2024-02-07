<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'sometimes',
            'description'=>'sometimes',
            'price'=>'sometimes',
            'userId'=>'sometimes',
            'categoryId'=>'sometimes',
            'image'=>'nullable',
        ];
        
    }
    
}
