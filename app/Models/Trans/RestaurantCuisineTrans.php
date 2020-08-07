<?php

namespace App\Models\Trans;

use App\Models\RestaurantCuisine;
use Illuminate\Database\Eloquent\Model;

class RestaurantCuisineTrans extends Model
{
    protected $table = 'restaurant_cuisine_trans';
    protected $fillable = ['title', 'lang', 'slug_article'];


    public function item()
    {
        return $this->belongsTo(RestaurantCuisine::class, 'slug_article', 'slug');
    }

}
