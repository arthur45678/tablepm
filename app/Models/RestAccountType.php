<?php

namespace App\Models;

use App\Models\Trans\RestAccountTypeTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestAccountType extends BaseModel
{
    protected $table = 'restaurantAccountType';
    protected $fillable = ['slug', 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(RestAccountTypeTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function restaurant()
    {
        return $this->hasMany(RestaurantCompany::class, 'accountType_id', 'id');
    }

    public function getAllTransData($slug)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = RestAccountTypeTrans::where(['slug_article' => $slug, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article->title . '|';
        }

        return trim($str, '|');
    }

}
