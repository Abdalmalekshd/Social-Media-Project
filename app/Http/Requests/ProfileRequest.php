<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_id'       =>'required|exists:users,id',
            'avatar'        =>'nullable|mimes:png,jpg',
            'name'          =>'required|min:4|max:30',
            'phone'         =>'required|min:8|numeric|unique:users,phone,'.$this->user()->id,
            'email'         =>'required|email|unique:users,email,'.$this->user()->id,
            'description'   =>'nullable|min:4|max:70',
            
            'country_id'=>'required|exists:countries,id'
        ];
    }


    public function messages()
    {
        return [
            
            'user_id.exists'=>__('messages.userid'),

            'avatar.mimes'=>__('messages.avatarformat'),
            
            'name.required'=>__('messages.namereq'),
            
            'name.min'=>__('messages.namemin'),

            'name.max'=>__('messages.namemax'),

            'phone.required'=>__('messages.phonereq'),
            
            'phone.numeric'=>__('messages.phonenum'),
            
            'phone.unique'=>__('messages.phoneunique'),

            'phone.min'=>__('messages.phonemin'),

            'email.required'=>__('messages.emailerrors'),

            'email.email'=>__('messages.emailformaterrors'),

            'email.unique'=>__('messages.emailunique'),

            'description.min'=>__('messages.descmin'),
            
            'description.max'=>__('messages.descmax'),


            
        ];
    }
}
