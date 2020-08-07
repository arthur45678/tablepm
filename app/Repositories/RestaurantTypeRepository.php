<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/17/2018
 * Time: 12:31 PM
 */

namespace App\Repositories;


use App\Models\RestaurantCuisine;
use App\Models\RestaurantType;
use App\Models\Trans\RestAccountTypeTrans;
use App\Models\Trans\RestaurantCuisineTrans;

use App\Models\Trans\RestaurantTypeTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class RestaurantTypeRepository extends Repository
{
    public function __construct()
    {
        $this->model = new RestaurantType();
    }

    public function addItem($request)
    {
        //   $errors = $request->check($request);
        $data = $request->all();
        $obj = $this->model;

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

        if($request->hasFile('img')){
            $width = Config::get('settings.restaurantCompany.img.width');
            $height = Config::get('settings.restaurantCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/


        // }
        $result = $obj->create($data);
        return $result;
    }


    public function addItemTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new RestaurantTypeTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
                // $data['desc'] = $input['desc'][$localeCode];
                //$data['text'] = $input['text'][$localeCode];
                //$data['meta_desc'] = $input['meta_desc'][$localeCode];
                //$data['keywords'] = $input['keywords'][$localeCode];
                $data['lang'] = $localeCode;
                $data['restaurantType_id'] = $article_result->id;
                $translate = $translation->create($data);

            }
        }
    }

    public function updateItem($request, $id)
    {
        $item = $this->model::findOrFail($id);
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

    public function updateItemTranslate($request, $id)
    {
        $item = $this->model::findOrFail($id);
        $translation = new RestaurantTypeTrans();

        $input = $request->except('_token');
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {
                $translate = $translation->where(['restaurantType_id' => $item->id, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['restaurantType_id'] = $item->id;

                $translate = $translation->where(['restaurantType_id' => $item->id, 'lang' => $localeCode])->first();


                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = $translation->create($data);
                }
            }
        }
    }




}