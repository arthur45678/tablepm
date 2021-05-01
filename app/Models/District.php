<?php

namespace App\Models;

use App\Models\Trans\DistrictTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class District extends Model
{
    protected $table = 'districts';
    protected $fillable = ['country_id', 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(DistrictTrans::class, 'district_id', 'id')
            ->where(['lang' => $lang]);
    }

    public function restaurant()
    {
        return $this->hasMany(RestaurantCompany::class, 'district_id', 'id');
    }



    public function getAllTransData($id)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = DistrictTrans::where(['district_id' => $id, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }


}
