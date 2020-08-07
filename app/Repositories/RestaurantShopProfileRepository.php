<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/17/2018
 * Time: 4:49 PM
 */

namespace App\Repositories;

use App\Contracts\RestaurantShopProfileInterface;
use App\Models\Dish;
use App\Models\RestaurantCompany;
use App\Models\RestaurantCuisine;
use App\Models\Trans\RestaurantShopProfileTranslation;
use App\Models\RestaurantShopProfile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\ImageOptimization;
use App\User;

class RestaurantShopProfileRepository implements RestaurantShopProfileInterface
{
    public function __construct()
    {
        $this->model = new RestaurantShopProfile();
    }


    public function addBookmark($ids, $auth_user_id)
    {
        $user = User::findOrfail($auth_user_id);

        if(isset($user)){
            if($ids){
                $user->bookmarkedRestaurantShop()->sync($ids,false);
            }
        }
    }

    public function deleteBookmark($ids, $auth_user_id)
    {
        $user = User::findOrfail($auth_user_id);

        $user->bookmarkedRestaurantShop()->detach($ids);
    }


    public function getUserBookmarks($user_id)
    {
        $user = User::findOrFail($user_id);
        return $user->bookmarkedRestaurantShop()->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function addItem($request)
    {
        //   $errors = $request->check($request);
        $data = $request->all();
        $obj = $this->model;

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
        (isset($request->slug) ? $data['slug'] = Repository::createSlug($request->slug) : $data['slug'] = Repository::createSlug());
        (isset($request->liquor_license) ? $data['liquor_license'] = 1 : $data['status'] = 0 );
        (isset($request->restaurant_status) ? $data['restaurant_status'] = 1 : $data['restaurant_status'] = 0 );
        if($request->hasFile('img')){
            $width = Config::get('settings.restaurantCompany.img.width');
            $height = Config::get('settings.restaurantCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/


        // }
        $result = $obj->create($data);
        return $result;
    }

    public function addRestCuisines($request, $obj)
    {
        $ids = isset($request->cuisines) ? $request->cuisines : null;
        if($ids){
            $obj->restCuisines()->sync($ids);
        }
        return $obj;
    }

    public function addRestDishes($request, $obj)
    {

        $ids = isset($request->dishes) ? $request->dishes : null;
        if($ids){
            $obj->dishes()->sync($ids);
        }
        return $obj;
    }




    public function addItemTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new RestaurantShopProfileTranslation();
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

    public function updateItem($request, $id)
    {
        $item = $this->model::findOrFail($id);
        //   $errors = $request->check($request);
        $data = $request->all();

        //  dd($request->all());

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
        (isset($request->liquor_license) ? $data['liquor_license'] = 1 : $data['status'] = 0 );
        (isset($request->restaurant_status) ? $data['restaurant_status'] = 1 : $data['restaurant_status'] = 0 );

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
        $translation = new RestaurantShopProfileTranslation();

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

    public function updateRestShopDishes($request, $item_id)
    {
        $ids = $request->dishes;
        $item = $this->model::findOrfail($item_id);
        if(isset($item)){
            if($ids){
                $item->dishes()->sync($ids);
            }else{
                $item->dishes()->detach();
            }
        }
    }


    public function updateRestShopCuisines($request, $item_id)
    {
        $ids = $request->cuisines;
        $item = $this->model::findOrfail($item_id);
        if(isset($item)){
            if($ids){
                $item->restCuisines()->sync($ids);
            }else{
                $item->restCuisines()->detach();
            }
        }
    }


    public function getRestaurantShopsLocations()
    {
        $result = DB::table('restaurant_shop_profiles')
            ->select('*',
                'restaurant_shop_profiles.lat AS lat',
                'restaurant_shop_profiles.lng AS lng',
                'restaurant_shop_profiles.id AS id',

                //'restaurant_companies.website_url',
                'restaurant_shop_profile_translations.title'
            )
            ->leftJoin('restaurant_shop_profile_translations', 'restaurant_shop_profile_translations.slug_article', '=', 'restaurant_shop_profiles.slug')
            ->leftJoin('restaurant_companies', 'restaurant_shop_profiles.parent_id', '=', 'restaurant_companies.id')

            ->where(['restaurant_shop_profile_translations.lang' => 'en'])
            ->get();


        return $result;
    }


    public function getSertaurantShops($restaurant_id)
    {
        return RestaurantShopProfile::where(['parent_id' => $restaurant_id])->paginate(15);
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