<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name_ar' => 'required|string|max:15',
            'last_name_ar' => 'required|string|max:15',
            'first_name_en' => 'required|string|max:15',
            'last_name_en' => 'required|string|max:15',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'emp_id' => 'required|string|unique:users|max:6',
        ];
    }
}
