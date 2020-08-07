<?php

namespace App\Models;

use App\Models\District;
use App\Models\Trans\ShopTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class Shop extends Model
{
    protected $table = 'shops';
    protected $fillable = ['status', 'lat', 'lng', 'street', 'phone', 'country_id', 'district_id', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(ShopTrans::class, 'shop_id', 'id')
            ->where(['lang' => $lang]);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

}
