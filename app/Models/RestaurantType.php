<?php

namespace App\Models;

use App\Models\Trans\RestAccountTypeTrans;
use App\Models\Trans\RestaurantTypeTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestaurantType extends Model
{
    protected $table = 'restaurantTypes';
    protected $fillable = [ 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(RestaurantTypeTrans::class, 'restaurantType_id', 'id')
            ->where(['lang' => $lang]);
    }


    public function getAllTransData($id)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = RestaurantTypeTrans::where(['restaurantType_id' => $id, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }

    public function restaurants()
    {
        return $this->belongsToMany(RestaurantCompany::class, 'restaurantTypes_restaurantCompany', 'restaurantType_id', 'restaurantCompany_id');
    }


    public function checkHasRestaurantType($article_id)
    {

        if($this->restaurants()->where(['restaurantType_id' => $this->id, 'restaurantCompany_id' => $article_id])->first()){
            return $this->id;
        }
        return false;

    }

}
