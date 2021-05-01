<?php

namespace App\Models;

use App\Models\Trans\IndustriesAdvertCompaniesTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class IndustriesAdvertCompanies extends Model
{
    protected $table = 'industries_advert_companies';
    protected $fillable = ['slug', 'status', 'img'];

    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(IndustriesAdvertCompaniesTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function getAllTransData($slug)
    {
        $str = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $article = IndustriesAdvertCompaniesTrans::where(['slug_article' => $slug, 'lang' => $localeCode])->first();

            $str .= $properties['native'] . '->' . $article['title'] . '|';
        }

        return trim($str, '|');
    }


    public function checkHasIndustry($indus_c_id = false, $adver_comp_id = false)
    {

        if($indus_c_id && $adver_comp_id){
            $sql = "SELECT indus_c_id, adver_comp_id FROM  industries_advert_companies AS  industries_advert_companies
                LEFT JOIN industries_advertiserscompanies  ON  industries_advert_companies.id = industries_advertiserscompanies.indus_c_id
                WHERE industries_advertiserscompanies.indus_c_id = {$indus_c_id} AND industries_advertiserscompanies.adver_comp_id = {$adver_comp_id}";

            $result = DB::select($sql);

            if(count($result) > 0){
                return true;
            }
            return false;
        }
        return false;
    }

}
