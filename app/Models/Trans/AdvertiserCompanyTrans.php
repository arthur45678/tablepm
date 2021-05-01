<?php

namespace App\Models\Trans;

use App\Models\AdvertiserCompany;
use Illuminate\Database\Eloquent\Model;

class AdvertiserCompanyTrans extends Model
{
    protected $table = 'advertiser_companies_trans';
    protected $fillable = ['slug_article', 'title', 'lang'];

    public function advertiserCompany()
    {
        return $this->belongsTo(AdvertiserCompany::class, 'slug_article', 'slug');
    }
}
