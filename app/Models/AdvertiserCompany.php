<?php

namespace App\Models;

use App\Models\Trans\AdvertiserCompanyTrans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\User;

class AdvertiserCompany extends BaseModel
{
    protected $table = 'advertiser_companies';
    protected $fillable = ['slug', 'status', 'img', 'block', 'floor', 'flat', 'estate_building', 'street',  'district_id',
        'email', 'phone', 'mobile', 'website_url', 'industry', 'user_id', 'country_id', 'lat', 'lng'];


    public function trans($lang = false)
    {
        if(!$lang){$lang = App::getLocale();}

        return $this->hasMany(AdvertiserCompanyTrans::class, 'slug_article', 'slug')
            ->where(['lang' => $lang]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function industries()
    {
        return $this->belongsToMany(IndustriesAdvertCompanies::class, 'industries_advertiserscompanies', 'adver_comp_id', 'indus_c_id');
    }

    public function bookmarked()
    {
        return $this->belongsToMany(User::class, 'bookmark_advertisercompanies', 'advert_comp_id', 'user_id');
    }


    public function addAdvertCompany($request)
    {
        $errors = $request->check($request);
        $data = $request->all();

        // No errors, Minimum one language filled
        if(!$errors){
            (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
            (isset($request->slug) ? $data['slug'] = self::createSlug($request->slug) : $data['slug'] = self::createSlug());
            if($request->hasFile('img')){
                $width = Config::get('settings.addAdvertCompany.img.width');
                $height = Config::get('settings.article_image.img.height');
                $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

            }/*Article full image*/


        }
        $result = self::create($data);
        return $result;
    }


    public function addAdvertCompanyTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new AdvertiserCompanyTrans();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $data = [];
            if(isset($input['title'][$localeCode])){
                $data['title'] = $input['title'][$localeCode];
               // $data['desc'] = $input['desc'][$localeCode];
                //$data['text'] = $input['text'][$localeCode];
                //$data['meta_desc'] = $input['meta_desc'][$localeCode];
                //$data['keywords'] = $input['keywords'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $article_result->slug;
                $translate = $translation->create($data);

            }
        }
    }



    public function updateAdvertCompany($request, $id)
    {
        $item = self::findOrFail($id);
        $errors = $request->check($request);
        $data = $request->all();

      //  dd($request->all());

        // No errors, Minimum one language filled
        if(!$errors){
            (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

            if($request->hasFile('img')){
                $width = Config::get('settings.addAdvertCompany.img.width');
                $height = Config::get('settings.article_image.img.height');
                $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

            }/*Article full image*/
        }


        $result = $item->update($data);
        return $result;

    }

    public function updateAdvertCompanyTranslate($request, $id)
    {
        $item = self::findOrFail($id);
        $translation = new AdvertiserCompanyTrans();

        $input = $request->except('_token');
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {
                $translate = $translation->where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $item->slug;

                $translate = $translation->where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();


                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = $translation->create($data);
                }
            }
        }
    }

}
