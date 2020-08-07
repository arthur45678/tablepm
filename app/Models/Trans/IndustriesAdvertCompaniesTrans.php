<?php

namespace App\Models\Trans;

use App\Models\IndustriesAdvertCompanies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class IndustriesAdvertCompaniesTrans extends Model
{
    protected $table = 'industries_advert_companies_trans';
    protected $fillable = ['title', 'lang', 'slug_article'];

    public function item()
    {
        return $this->belongsTo(IndustriesAdvertCompanies::class, 'slug_article', 'slug');
    }
}
