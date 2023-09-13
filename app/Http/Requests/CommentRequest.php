<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'id'        =>'required|exists:comments,id',
            'post_id'   =>'exists:posts,id',
            'comment'   =>'required|max:100',
            
        ];
    }



    public function messages()
    {
        return [
            'id.required'=>__('messages.userid'),
            'id.exists'=>__('messages.userid'),

            'comment.required'=>__('messages.comment_Required'),
            'comment.max'=>__('messages.comment_max'),
        ];
    }
}
