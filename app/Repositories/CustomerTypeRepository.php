<?php

namespace App\Repositories;

use App\Models\CustomerTypeRestaurants;
use App\Models\Trans\CustomerTypeRestaurantsTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Contracts\CustomerTypeContract;

class CustomerTypeRepository implements CustomerTypeContract
{
    /**
     * Object of CustomerTypeRestaurants class.
     *
     * @var $model 
     */
    private $model;

    /**
     * Create a new instance of CustomerTypeRepository class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new CustomerTypeRestaurants();
    }

    /**
     * get all customer types
     */
    public function getAllCustomerTypes()
    {
        return $this->model->paginate(Config::get('settings.admin.articles.paginate'));
    }

    /**
     * create new customer type
     */
    public function crateCustomerType($data)
    {
        return $this->model->create($data);
    }


    public function addItemTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new CustomerTypeRestaurantsTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $article_result->slug;

                $translate = $translation->create($data);

            }
        }

    }

    public function updateItem($data, $id)
    {
        // $item = $this->model::findOrFail($id);
        // //   $errors = $request->check($request);
        // $data = $request->all();

        // //  dd($request->all());

        // // No errors, Minimum one language filled
        // //  if(!$errors){
        // (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );



        // $result = $item->update($data);
        // // $result = $item->update($data);

        // return $result;
        return $this->model->where('id', $id)->update($data);
    }

    public function updateItemTranslate($request, $id)
    {
        $item = $this->model::findOrFail($id);
        $translation = new CustomerTypeRestaurantsTrans();

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

    /**
     * get one customer type by id
     */
    public function getCustomerTypeById($id)
    {
        return $this->model->where('id', $id)->first();
    }



    public function deleteItem($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getAllNoPagination()
    {
        return $this->model->get();
    }

}