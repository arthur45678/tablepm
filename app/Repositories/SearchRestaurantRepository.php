<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/17/2018
 * Time: 4:49 PM
 */

namespace App\Repositories;


use App\Models\Dish;
use App\Models\RestaurantCuisine;
use App\Models\SearchRestaurant;
use App\Models\Trans\RestaurantShopProfileTranslation;
use App\Models\RestaurantShopProfile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\ImageOptimization;

class SearchRestaurantRepository extends Repository
{
    public function __construct()
    {
        $this->model = new SearchRestaurant();
    }




    public function advancedSearch($request)
    {
        $data = $request->all();
        $restaurantShop = new RestaurantShopProfile();

        $query = $restaurantShop::query();


        // Seat numbers
        if(isset($data['seat_number'])){
            switch ($data['seat_number']){
                case "0-50":
                    $query->where([
                        ['seat_number', '>', 0],
                        ['seat_number', '<=', 50],
                    ]);
                    break;
                case "51-100":
                    $query->where([
                        ['seat_number', '>', 51],
                        ['seat_number', '<=', 100],
                    ]);
                    break;
                case "101-200":
                    $query->where([
                        ['seat_number', '>=', 101],
                        ['seat_number', '<=', 200],
                    ]);
                    break;
                case "200<":
                    $query->where([
                        ['seat_number', '>', 200],
                    ]);
                    break;
            }
        }


        if(isset($data['wifi_ssid'])){
            $query->where([
                ['wifi_ssid', '!=', null]
            ]);
        }

        if (isset($data['liquor_license'])){
            $query->where([
                ['liquor_license', '!=', '0']
            ]);
        }



        if(isset($data['district_id']))
        {
            $tempIds = [];
            $districtIds = $data['district_id'];
            foreach ($districtIds as $key => $districtId)
            {
                array_push($tempIds, $districtId);
            }
            $query->whereHas('district', function($query) use ($tempIds){
                $query->whereIn('district_id', $tempIds);
            });
        }

        if(isset($data['restcuisines_id']))
        {
            $tempIds = [];
            $restcuisinesIds = $data['restcuisines_id'];
            foreach ($restcuisinesIds as $key => $restcuisinesId)
            {
                array_push($tempIds, $restcuisinesId);
            }
            $query->whereHas('restCuisines', function($query) use ($tempIds){
                $query->whereIn('restcuisines_id', $tempIds);
            });

        }

        return $query;








        /* if(isset($data['customer_id']))
         {
             $tempIds = [];
             $customerIds = $data['customer_id'];
             foreach ($customerIds as $key => $customerId)
             {
                 array_push($tempIds, $customerId);
             }
             $query->whereHas('customerTypes', function($query) use ($tempIds){
                 $query->whereIn('customer_id', $tempIds);
             });
            // dd($query->get());
         }


         if(isset($data['restaurantType_id']))
         {
             $tempIds = [];
             $restaurantTypeIds = $data['restaurantType_id'];
             foreach ($restaurantTypeIds as $key => $restaurantTypeId)
             {
                 array_push($tempIds, $restaurantTypeId);
             }
             $query->whereHas('restaurantTypes', function($query) use ($tempIds){
                 $query->whereIn('restaurantType_id', $tempIds);
             });

         }*/
    }


    public function searchByDistrict($request)
    {
        return RestaurantShopProfileTranslation::where(['lang' => App::getLocale()]);
    }


}