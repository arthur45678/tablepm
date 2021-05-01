<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/17/2018
 * Time: 11:21 AM
 */

namespace App\Repositories;
use App\Models\Dish;
use App\Models\Trans\DishTrans;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DishRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Dish();
    }

    public function addDish($request)
    {
        //   $errors = $request->check($request);
        $data = $request->all();
        $obj = new Dish();

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
        (isset($request->slug) ? $data['slug'] = self::createSlug($request->slug) : $data['slug'] = self::createSlug());
        if($request->hasFile('img')){
            $width = Config::get('settings.restaurantCompany.img.width');
            $height = Config::get('settings.restaurantCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/


        // }
        $result = $obj->create($data);
        return $result;
    }


    public function addDishTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new DishTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
                // $data['desc'] = $input['desc'][$localeCode];
                //$data['text'] = $input['text'][$localeCode];
                //$data['meta_desc'] = $input['meta_desc'][$localeCode];
                //$data['keywords'] = $input['keywords'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $article_result->slug;
                $translate = $translation->create($data);

            }
        }
    }

    public function updateDish($request, $id)
    {
        $item = Dish::findOrFail($id);
        //   $errors = $request->check($request);
        $data = $request->all();

        //  dd($request->all());

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

        if($request->hasFile('img')){
            $width = Config::get('settings.addAdvertCompany.img.width');
            $height = Config::get('settings.addAdvertCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/
        //    }


        $result = $item->update($data);
        // $result = $item->update($data);

        return $result;
    }

    public function updateDishTranslate($request, $id)
    {
        $item = Dish::findOrFail($id);
        $translation = new DishTrans();

        $input = $request->except('_token');
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {
                $translate = $translation->where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $item->slug;

                $translate = $translation->where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();


                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = $translation->create($data);
                }
            }
        }
    }
}