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
            
            'gender' => 'sometimes | required | string',
            'civil_status' => 'sometimes | nullable | string',
            'address' => 'sometimes | required | string',
            'contact' => 'sometimes | required | integer',
            'bio' => 'sometimes | string',
            'skills' => 'sometimes | string',
            'date_of_birth' => 'sometimes | date',
            'image' => 'nullable | string',
        ];
    }

    public function messages()
    {
        return [
            
            'contact.integer' => 'Mobile number should not start with a ( 0 / Zero )'
        ];
    }
}
