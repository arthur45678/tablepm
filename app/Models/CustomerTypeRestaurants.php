<?php

namespace App\Models;

use App\Models\Trans\CustomerTypeRestaurantsTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerTypeRestaurants extends Model
{
    protected $table = 'customerTypesRestaurants';
    protected $fillable = ['slug', 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(CustomerTypeRestaurantsTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function restaurant()
    {
        return $this->belongsToMany(RestaurantCompany::class, 'customerTypes_restCompanies', 'customer_id', 'restcomp_id');
    }

    public function getAllTransData($slug)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = CustomerTypeRestaurantsTrans::where(['slug_article' => $slug, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }


    public function checkHasCustomerTypeRestaurant($article_id)
    {

        if($this->restaurant()->where(['customer_id' => $this->id, 'restcomp_id' => $article_id])->first()){
            return $this->id;
        }
        return false;

    }



}
