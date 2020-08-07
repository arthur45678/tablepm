<?php

namespace App\Models\Trans;

use App\Models\RestAccountType;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RestAccountTypeTrans extends Model
{
    protected $table = 'restaurantAccountType_trans';
    protected $fillable = ['title', 'lang', 'slug_article'];

    public function item()
    {
        return $this->belongsTo(RestAccountType::class, 'slug_article', 'slug');
    }
}
