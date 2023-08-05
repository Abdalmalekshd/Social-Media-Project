<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'postId'   =>'exists:posts,id',
            'userId'   =>'exists:users,id',
            'commentId'   =>'exists:comments,id',
            'reason'   =>'required|in:Sexaulty,Violence,Fake News,Fraud',
            
        ];
    }



    public function messages()
    {
        return [
            
            'userId.exists'   =>__('messages.userid'),
            'postId.exists'   =>__('messages.userid'),
            'commentId.exists'=>__('messages.userid'),
            'reason.required' =>__('messages.reasonreq'),
        ];
    }
}
