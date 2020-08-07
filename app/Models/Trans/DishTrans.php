<?php

namespace App\Models\Trans;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Model;

class DishTrans extends Model
{
    protected $table = 'dish_trans';
    protected $fillable = ['title', 'lang', 'slug_article'];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'slug_article', 'slug');
    }
}
