<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
            // 'contact_name' => 'required|max:255',
            // 'role_id' => 'required|integer',
        ];
    }

    /**
     * return inputs from the request
     */
    public function data($request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $roleId = $request->role_id;

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => $roleId
        ];

        return $data;
    }
}
