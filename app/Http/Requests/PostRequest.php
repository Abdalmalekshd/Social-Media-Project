<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            
            'content'   =>'required|max:100',
            'image'     =>'required|array|min:1',
            
        ];
    }



    public function messages()
    {
        return [
            'content.required'=>__('messages.contentRequired'),
            'content.max'=>__('messages.contentmax'),


            'image.required'=>__('message.imgError'),
            
            // 'image.required'=>__('message.mimes'),
        ];
    }
}
