<?php

namespace App\Models;

use App\Models\District;
use App\Models\Trans\RestaurantShopProfileTranslation;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\User;

class RestaurantShopProfile extends Model
{
    protected $table = 'restaurant_shop_profiles';
    protected $fillable = ['parent_id', 'slug', 'status', 'img', 'block', 'floor', 'flat', 'estate_building', 'street', 'location', 'district_id', 'country_id',
        'opening_hours', 'account_number', 'buisness_registration', 'views', 'liquor_license', 'wifi_ssid', 'wifi_password', 'seat_number', 'seat_cost',
        'sticker_quantity', 'restaurant_status', 'email', 'phone', 'mobile',  'bank_account_name',  'bank_account_number',  'bank',  'user_id', 'lat', 'lng', 'link_company_profile'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(RestaurantShopProfileTranslation::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }


    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'restshopprofile_dish', 'restshopprofile_id', 'dish_id');
    }



    public function restCuisines()
    {
        return $this->belongsToMany(RestaurantCuisine::class, 'restshopprofile_cuisinetype', 'restshopprofile_id', 'restcuisines_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }


    public function restaurant()
    {
        return $this->belongsTo(RestaurantCompany::class, 'parent_id', 'id');
    }


}
