<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/16/2018
 * Time: 4:26 PM
 */

namespace App\Repositories;


use App\Contracts\DistrictsInterface;
use App\Models\District;
use App\Models\Trans\DistrictTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DistrictsRepository implements DistrictsInterface
{
    private $model;


    public function __construct()
    {
        $this->model = new District();
    }



    public function addItem($request)
    {
        //   $errors = $request->check($request);
        $data = $request->all();
        $obj = $this->model;

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

        // }
        $result = $obj->create($data);
        return $result;
    }


    public function addItemTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new DistrictTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
                // $data['desc'] = $input['desc'][$localeCode];
                //$data['text'] = $input['text'][$localeCode];
                //$data['meta_desc'] = $input['meta_desc'][$localeCode];
                //$data['keywords'] = $input['keywords'][$localeCode];
                $data['lang'] = $localeCode;
                $data['district_id'] = $article_result->id;

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



        $result = $item->update($data);
        // $result = $item->update($data);

        return $result;
    }

    public function updateItemTranslate($request, $id)
    {
        $item = $this->model::findOrFail($id);
        $translation = new DistrictTrans();

        $input = $request->except('_token');
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {
                $translate = $translation->where(['district_id' => $item->id, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['district_id'] = $item->id;

                $translate = $translation->where(['district_id' => $item->id, 'lang' => $localeCode])->first();


                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = $translation->create($data);
                }
            }
        }
    }

    public function getOnlyTranslation()
    {
        return DistrictTrans::all();
    }


    public function getAllCuisines()
    {
        return RestaurantCuisine::all();
    }


    public function getAllDishes()
    {
        return Dish::all();
    }

    public function getByID($id){
        return $this->model::findOrFail($id);
    }


    public function getAll()
    {
        return $this->model::orderBy(
            'id', Config::get('settings.admin.articles.orderBy')
        )->paginate(Config::get('settings.admin.articles.paginate'));

    }

    public function getAllNoPagination()
    {
        return $this->model::all();
    }


    public function deleteItem($id)
    {
        return $this->model::findOrFail($id)->delete();
    }

}