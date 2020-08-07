<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/17/2018
 * Time: 4:49 PM
 */

namespace App\Repositories;

use App\Contracts\ShopInterface;

use App\Models\Shop;
use App\Models\Trans\ShopTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\ImageOptimization;
use App\User;

class ShopRepository implements ShopInterface
{
    private $model;


    public function __construct()
    {
        $this->model = new Shop();
    }



    public function addItem($data)
    {
        //   $errors = $request->check($request);
        $obj = $this->model;

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($data['status']) ? $data['status'] = 1 : $data['status'] = 0 );



        // }
        $result = $obj->create($data);
        return $result;
    }





    public function addItemTranslate($input, $article_result)
    {
        $translation = new ShopTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
                // $data['desc'] = $input['desc'][$localeCode];
                //$data['text'] = $input['text'][$localeCode];
                //$data['meta_desc'] = $input['meta_desc'][$localeCode];
                //$data['keywords'] = $input['keywords'][$localeCode];
                $data['lang'] = $localeCode;
                $data['shop_id'] = $article_result->id;
                $translate = $translation->create($data);

            }
        }
    }

    public function updateItem($data, $id)
    {
        $item = $this->model::findOrFail($id);


        //   $errors = $request->check($request);

        //  dd($request->all());

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($data['status']) ? $data['status'] = 1 : $data['status'] = 0 );





        $result = $item->update($data);
        // $result = $item->update($data);

        return $result;
    }

    public function updateItemTranslate($input, $id)
    {
        $item = $this->model::findOrFail($id);
        $translation = new ShopTrans();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {

                $translate = $translation->where(['shop_id' => $item->id, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['shop_id'] = $item->id;

                $translate = $translation->where(['shop_id' => $item->id, 'lang' => $localeCode])->first();



                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = $translation->create($data);
                }
            }
        }
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