<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OldPasswordRequest extends FormRequest
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
            'old_password'   =>'required',
            'new_password'   =>'required|min:8',
            
        ];
    }



    public function messages()
    {
        return [
            
            // 'comment.required'=>__('messages.comment_Required'),
            // 'comment.max'=>__('messages.comment_max'),
        ];
    }
}
