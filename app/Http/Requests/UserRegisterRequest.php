<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|numeric',
            'phone_code' => 'required',
            'company_name' => 'required',
        ];
    }

    public function data($request)
    {
        $data = $request->all();
        $data['token'] = str_random(25);
        $data['password'] = bcrypt($request->password);
        $data['role_id'] = 4;
        return $data;
    }
}
