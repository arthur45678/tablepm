<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShopRequest extends FormRequest
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
        return $request->except('_token');
    }
}
