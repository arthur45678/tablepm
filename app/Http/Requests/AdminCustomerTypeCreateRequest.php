<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;


class AdminCustomerTypeCreateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $locales = LaravelLocalization::getSupportedLocales();
        $rules = [];
        $names = [];
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $names[] = 'title.' . $localeCode;
        }
        $names = collect($names);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules['title.'. $localeCode] = 'required_without_all:' . $this->getExcept($names, 'title.' . $localeCode);
        }
        return $rules;
    }

    /**
     * returns collection without the given value
     */
    private function getExcept($collection, $exception) {
        return $collection->reject(function ($item) use ($exception) {
            return $item == $exception;
        })->implode(',');
    }

    public function data($request)
    {
        $data = $request->all();
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
        $data['slug'] = str_random(10);
        return $data;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required_without_all' => 'Please fill the title in at least one language.',
        ];
    }
    
}
