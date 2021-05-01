<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator;
use Illuminate\Http\Request;
use App\Models\AdvertiserCompany;
use App\Models\Trans\AdvertiserCompanyTrans;


class AdvertiserCompanyRequest extends FormRequest
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

        $countTitle = 0;
        $messages = [];
        $point = 1;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){

            if($input['title'][$localeCode]){
                $countTitle++;
            }
        }

        if($countTitle == 0){

            $messages['Важно ' . $point] = 'Заполните данные хотья бы на одном языке';
            $point++;
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

    public function validateCompany($request)
    {
        $messages = $request->check($request);

        $validator = Validator::make($request->all(), [
            'street' => 'required',
            'district_id' => 'required',
            'img' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            if($messages){
                foreach ($messages as $key=>$value) {
                    $validator->errors()->add($key, $value);
                }
            }
            return redirect()->route('admin.advertiserCompanies.create')
                ->withErrors($validator)
                ->withInput();
        }

        if($messages){
            foreach ($messages as $key=>$value) {
                $validator->errors()->add($key, $value);
            }
            return redirect()->route('admin.advertiserCompanies.create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = $this;
        $rules = [
            'street' => 'required',
            'district_id' => 'required',
            'img' => 'nullable|image',
        ];

        $titleCount = 0;

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){

            if($input['title'][$localeCode]){
                $titleCount++;

            }
        }

        if ($titleCount == 0){
            $rules[$localeCode] = 'required|min:1';
        }
        return $rules;
    }

}
