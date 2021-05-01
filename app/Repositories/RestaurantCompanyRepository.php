<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/13/2018
 * Time: 4:30 PM
 */

namespace App\Repositories;

use App\Models\ImageOptimization;
use App\Models\RestaurantCompany;
use App\Models\Trans\RestaurantCompanyTrans;
use App\Models\Trans\RestaurantShopProfileTranslation;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class RestaurantCompanyRepository extends Repository
{

    public function __construct()
    {
        $this->model = new RestaurantCompany();
    }


    public function addBookmark($ids, $auth_user_id)
    {
        $user = User::findOrfail($auth_user_id);
        if(isset($user)){
            if($ids){
                $user->bookmarkedRestaurants()->sync($ids,false);
            }
        }
    }

    public function deleteBookmark($ids, $auth_user_id)
    {
        $user = User::findOrfail($auth_user_id);

        $user->bookmarkedRestaurants()->detach($ids);
    }


    public function getUserBookmarks($user_id)
    {
        $user = User::findOrFail($user_id);
        return $user->bookmarkedRestaurants()->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function addCustomerTypes($request, $obj)
    {
        $ids = isset($request->customerTypes) ? $request->customerTypes : null;
        if($ids){
            $obj->customerTypes()->sync($ids);
        }
        return $obj;
    }

    public function addRestaurantTypes($request, $obj)
    {
        $ids = isset($request->restaurantTypes) ? $request->restaurantTypes : null;
        if($ids){
            $obj->restaurantTypes()->sync($ids);
        }
        return $obj;
    }



    public static function updateCustomerTypes($request, $item_id)
    {
        $item = RestaurantCompany::findOrFail($item_id);
        $ids = isset($request->customerTypes) ? $request->customerTypes : null;
        if(isset($item)){
            if($ids){
                $item->customerTypes()->sync($ids);
            }else{
                $item->customerTypes()->detach();
            }
        }
    }

    public static function updateRestaurantTypes($request, $item_id)
    {
        $item = RestaurantCompany::findOrFail($item_id);
        $ids = isset($request->restaurantTypes) ? $request->restaurantTypes : null;
        if(isset($item)){
            if($ids){
                $item->restaurantTypes()->sync($ids);
            }else{
                $item->restaurantTypes()->detach();
            }
        }
    }






    public function addRestaurantCompany($request, $user)
    {
        $user->role_id = 2;
        $user->save();

        $data = $request->all();

        // No errors, Minimum one language filled
      //  if(!$errors){
            (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
            (isset($request->slug) ? $data['slug'] = self::createSlug($request->slug) : $data['slug'] = self::createSlug());
            if($request->hasFile('img')){
                $width = Config::get('settings.restaurantCompany.img.width');
                $height = Config::get('settings.restaurantCompany.img.height');
                $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

            }/*Article full image*/

        $data['user_id'] = $user->id;

       // }
        $result = RestaurantCompany::create($data);
        return $result;
    }


    public function addRestaurantCompanyTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new RestaurantCompanyTrans();
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

    public function updateRestaurantCompany($request, $id)
    {
        $item = RestaurantCompany::findOrFail($id);
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

    public function updateRestaurantCompanyTranslate($request, $id)
    {
        $item = RestaurantCompany::findOrFail($id);
        $translation = new RestaurantCompanyTrans();


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


    public function deleteRestaurantCompany($id)
    {
        $restCompany = RestaurantCompany::findOrFail($id);
        $restCompany->user()->first()->delete();
        $restCompany->delete();
    }


    public function searchRestaurantCompany($request)
    {
        if($request->ajax()){
            $output = '';

            $trans = DB::table('restaurant_company_trans')
                ->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('id', $request->search)
                ->take(20)
                ->get();
            if($trans){
                foreach ($trans as $key=>$tran) {
                    $item = RestaurantCompany::where(['slug' =>$tran->slug_article])->first();
                    $output .= '<a href='.route('admin.RestaurantCompanies.getSearched', ['id' => $item->id]).'>'.$tran->title. '</a>' . '<br>';
                }

                return $output;
            }
        }
    }


    public function getLatestsRestaurantsShopsOnlyTranslates($lang = false ,$count = 6)
    {
        if(!$lang){$lang = App::getLocale();}

        return RestaurantShopProfileTranslation::where([
            'lang' => $lang,
        ])->take($count)->get();
    }


    public function getAllRestaurantLocations()
    {
        $result = DB::table('restaurant_companies')
            ->select('*',
                'restaurant_company_trans.title'
            )
            ->leftJoin('restaurant_company_trans', 'restaurant_company_trans.slug_article', '=', 'restaurant_companies.slug')
            ->where(['restaurant_company_trans.lang' => 'en'])
            ->get();

        return $result;

    /*     $dom = new \DOMDocument();
       $node = $dom->createElement("markers");
       $parnode = $dom->appendChild($node);

       foreach ($result as $item) {
           $node = $dom->createElement("marker");

           $newnode = $parnode->appendChild($node);
           $newnode->setAttribute("id", $item->id);
           $newnode->setAttribute("name", $item->title);
           $newnode->setAttribute("address", $item->street);
           $newnode->setAttribute("lat", $item->lat);
           $newnode->setAttribute("lng", $item->lng);
       //    $newnode->setAttribute("distance", $item->distance);
       }

       return $dom->saveXML();*/

    }

    public function showAllRestaurantLocations()
    {



        return   DB::table('restaurant_companies')
            ->select('*',
                'restaurant_company_trans.title'
                )
            ->leftJoin('restaurant_company_trans', 'restaurant_company_trans.slug_article', '=', 'restaurant_companies.slug')
            ->where(['restaurant_company_trans.lang' => 'en'])
            ->get();


       /* $dom = new \DOMDocument();
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        foreach ($result as $item) {
            $node = $dom->createElement("marker");

            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $item->id);
            $newnode->setAttribute("name", $item->title);
            $newnode->setAttribute("address", $item->street);
            $newnode->setAttribute("lat", $item->lat);
            $newnode->setAttribute("lng", $item->lng);
        //    $newnode->setAttribute("distance", $item->distance);
        }

        return $dom->saveXML();*/

    }


}