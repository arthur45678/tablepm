<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
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
            'phone_code' => 'required|integer',
            'contact_number' => 'required|integer',
            'company_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required',
        ];
    }


    /**
     * return inputs from the request
     */

    public function data($request)
    {
        $data = $request->only(['name', 'phone_code', 'contact_number', 'company_name', 'email', 'text']);

        return $data;
    }
}
