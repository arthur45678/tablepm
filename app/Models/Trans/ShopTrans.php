<?php

namespace App\Models\Trans;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShopTrans extends Model
{
    protected $table = 'shop_trans';
    protected $fillable = ['title', 'lang', 'shop_id'];
    public function item()
    {
        return $this->belongsTo(Shop::class, 'district_id', 'id');
    }
}
