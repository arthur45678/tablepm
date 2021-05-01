<?php

namespace App\Models\Trans;

use App\Models\CustomerTypeRestaurants;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustriesAdvertCompanies;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerTypeRestaurantsTrans extends Model
{
    protected $table = 'customerTypesRestaurants_trans';
    protected $fillable = ['title', 'lang', 'slug_article'];

    public function item()
    {
        return $this->belongsTo(CustomerTypeRestaurants::class, 'slug_article', 'slug');
    }
}
