<?php

namespace App\Models\Trans;

use App\Models\RestaurantShopProfile;
use Illuminate\Database\Eloquent\Model;

class RestaurantShopProfileTranslation extends Model
{
    protected $table = 'restaurant_shop_profile_translations';
    protected $fillable = ['title', 'lang', 'slug_article'];

    public function post()
    {
        return $this->belongsTo(RestaurantShopProfile::class, 'slug_article', 'slug');
    }

}
