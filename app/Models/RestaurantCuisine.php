<?php

namespace App\Models;

use App\Models\Trans\RestaurantCuisineTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestaurantCuisine extends Model
{
    protected $table = 'restaurant_cuisines';
    protected $fillable = ['slug', 'status', 'img',  'lat', 'lng'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(RestaurantCuisineTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }


    public function getAllTransData($slug)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = RestaurantCuisineTrans::where(['slug_article' => $slug, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }


    public function restaurantShopProfile()
    {
        return $this->belongsToMany(RestaurantShopProfile::class, 'restshopprofile_cuisinetype', 'restcuisines_id', 'restshopprofile_id');
    }

    public function checkHasCuisine($restcuisines_id = false, $restshopprofile_id = false)
    {

        if($restcuisines_id && $restshopprofile_id){
            $sql = "SELECT restcuisines_id, restshopprofile_id FROM restaurant_cuisines AS restaurant_cuisines
                LEFT JOIN restshopprofile_cuisinetype  ON restaurant_cuisines.id = restshopprofile_cuisinetype.restcuisines_id
                WHERE restshopprofile_cuisinetype.restcuisines_id = {$restcuisines_id} AND restshopprofile_cuisinetype.restshopprofile_id = {$restshopprofile_id}";

            $result = DB::select($sql);

            if(count($result) > 0){
                return true;
            }
            return false;
        }
        return false;
    }
}
