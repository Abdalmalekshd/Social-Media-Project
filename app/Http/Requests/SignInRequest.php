<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
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
            'name'=>'required|min:4|max:30',
            'email'=>'required|email|unique:users,email',
            'gender'=>'required|in:0,1',
            'phone'=>'required|numeric|min:8|unique:users,phone',
            'password'=>'required|alpha_num',
            'lives_in'=>'required',
            'country'=>'required|exists:countries,id'
        ];
    }



    public function messages()
    {
        return [
            'name.required'=>__('messages.namereq'),
            'name.min'=>__('messages.namemin'),
            'email.required'=>__('messages.emailerrors'),
            'email.email'=>__('messages.emailformaterrors'),
            'email.unique'=>__('messages.emailunique'),

            'phone.required'=>'Phone Is Required',
            'phone.numeric'=>'Phone Must Not Contain Letters Or Dashes',
            'phone.min'=>'phone Must Be larger Than 7 Letters',


            'password.required'=>'Password Is Required',
            'password.alpha_num'=>'Password Must Contain Letters',


            
        ];
    }
}
