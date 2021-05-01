<?php

namespace App\Models;

use App\Models\Trans\DishTrans;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Dish extends Model
{
    protected $table = 'dishes';
    protected $fillable = ['slug', 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(DishTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function getAllTransData($slug)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = DishTrans::where(['slug_article' => $slug, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }

    public function restaurantShopProfile()
    {
        return $this->belongsToMany(RestaurantShopProfile::class, 'restshopprofile_dish', 'dish_id', 'restshopprofile_id');
    }

    public function checkHasDish($dish_id = false, $restshopprofile_id = false)
    {

        if($dish_id && $restshopprofile_id){
            $sql = "SELECT dish_id, restshopprofile_id FROM dishes AS dishes
                LEFT JOIN restshopprofile_dish  ON dishes.id = restshopprofile_dish.dish_id
                WHERE restshopprofile_dish.dish_id = {$dish_id} AND restshopprofile_dish.restshopprofile_id = {$restshopprofile_id}";

            $result = DB::select($sql);

            if(count($result) > 0){
                return true;
            }
            return false;
        }
        return false;
    }

}
