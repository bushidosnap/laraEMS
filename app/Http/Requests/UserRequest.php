<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required | string | max:191',
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')->ignore($this->id)],
            'type' => 'sometimes | string',
            'password' => 'sometimes | string | min:6 | max: 100',

        ];
    }
}
