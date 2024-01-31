<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'userId' => 'required',
            'categoryId' => 'required',
            'image'=>'required|mimes:jpeg,png,gif,svg'
            
        ];
    }
   
        public function messages(){
            return [
                'title.required' => 'Le champ titre est obligatoire.',
                'description.required' => 'Le champ description est obligatoire.',
                'price.required' => 'Le champ prix est obligatoire.',
                'userId.required' => 'Le champ id user est obligatoire.',
                'categoryId.required' => 'Le champ id category  est obligatoire.',
                'image.required' => 'Le champ image est obligatoire.',
            ];
        }


    }

