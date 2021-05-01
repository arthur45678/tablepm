<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerTypeRequest extends FormRequest
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


    public function check($request)
    {
        $input = $request->all();
        $point = 1;
        $countTitle = 0;
        $messages = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){

            if($input['title'][$localeCode]){
                $countTitle ++;
            }
        }

        if($countTitle == 0){

            $messages['Важно ' . $point] = 'Заполните данные хотья бы на одном языке';

        }

        if(count($messages) > 0){
            return $messages;
        }

        //No errors
        if(count($messages) == 0 && $countTitle > 0){
            return false;
        }
        return $messages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
