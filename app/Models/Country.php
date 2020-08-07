<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['title', 'lang'];

    public function districts()
    {
        return $this->hasMany(District::class, 'country_id', 'id');
    }
}
