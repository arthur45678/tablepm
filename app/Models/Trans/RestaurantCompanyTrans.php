<?php

namespace App\Models\Trans;

use App\Models\RestaurantCompany;
use Illuminate\Database\Eloquent\Model;

class RestaurantCompanyTrans extends Model
{
    protected $table = 'restaurant_company_trans';
    protected $fillable = ['slug_article', 'title', 'lang', 'desc', 'text', 'meta_desc', 'keywords'];

    public function restaurantCompany()
    {
        return $this->belongsTo(RestaurantCompany::class, 'slug_article', 'slug');
    }

    public function scopeSearch($query, $s)
    {
        return $query->where('title', 'like', '%' .$s. '%')
            ->orWhere('text', 'like', '%' .$s. '%');
    }
}
