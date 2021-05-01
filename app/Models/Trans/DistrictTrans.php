<?php

namespace App\Models\Trans;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DistrictTrans extends Model
{
    protected $table = 'districts_trans';
    protected $fillable = ['title', 'lang', 'district_id'];

    public function item()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
