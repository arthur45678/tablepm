<?php

namespace App\Models\Trans;

use App\Models\RestaurantType;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestaurantTypeTrans extends Model
{
    protected $table = 'restaurantType_trans';
    protected $fillable = ['title', 'lang', 'restaurantType_id'];


    public function item()
    {
        return $this->belongsTo(RestaurantType::class, 'restaurantType_id', 'id');
    }
}
