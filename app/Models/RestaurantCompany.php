<?php

namespace App\Models;

use App\Models\Trans\RestaurantCompanyTrans;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestaurantCompany extends Model
{
    protected $table = 'restaurant_companies';
    protected $fillable = ['slug', 'status', 'img', 'block', 'floor', 'flat', 'estate_building', 'street', 'district_id', 'account_number', 'buisness_registration', 'email', 'phone',
        'mobile',  'bank_account_name',  'bank_account_number', 'website_url',  'bank',  'user_id', 'country_id',  'lat', 'lng', 'accountType_id',
        ];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(RestaurantCompanyTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function bookmarked()
    {
        return $this->belongsToMany(User::class, 'bookmarked_restaurants', 'rest_comp_id', 'user_id');
    }

    public function customerTypes()
    {
        return $this->belongsToMany(CustomerTypeRestaurants::class, 'customerTypes_restCompanies', 'restcomp_id', 'customer_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function restaurantTypes()
    {
        return $this->belongsToMany(RestaurantType::class, 'restaurantTypes_restaurantCompany', 'restaurantCompany_id', 'restaurantType_id');
    }

    public function cuisines()
    {
        return $this->belongsToMany();
    }

    public function accountType()
    {
        return $this->belongsTo(RestAccountType::class, 'accountType_id', 'id');
    }

    public function shop()
    {
        return $this->hasMany(RestaurantShopProfile::class, 'parent_id', 'id');
    }


    public function checkHasInBookmar($user_id = false, $rest_comp_id = false)
    {
        if($user_id && $rest_comp_id){
            $sql = "SELECT user_id, rest_comp_id FROM users AS t
                LEFT JOIN bookmarked_restaurants  ON t.id = bookmarked_restaurants.user_id
                WHERE bookmarked_restaurants.user_id = {$user_id} AND bookmarked_restaurants.rest_comp_id = {$rest_comp_id}";

            $result = DB::select($sql);

            if(count($result) > 0){
                return true;
            }
            return false;
        }
        return false;

    }




}
