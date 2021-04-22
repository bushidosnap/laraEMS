<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentRequest extends FormRequest
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
            
            'user_id' => ' required | integer',
            'dept_id' => ' required | integer',
            'pos_id' => ' required | integer',
            'emp_type' => ' required | string',
            'contract_start' => 'date',
            'contract_end' => 'date | after:contract_start',
            'status' => 'required | integer',
        ];
    }

}
