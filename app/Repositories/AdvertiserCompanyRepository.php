<?php
namespace App\Repositories;


use App\Models\AdvertiserCompany;
use App\Models\Trans\AdvertiserCompanyTrans;
use App\Models\ImageOptimization;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\User;
use App\Contracts\AdvertiserCompanyContract;

class AdvertiserCompanyRepository implements AdvertiserCompanyContract
{
    public function __construct()
    {
        $this->model = new AdvertiserCompany();
        $this->modelTrans = new AdvertiserCompanyTrans();
    }


    public function addAdvertCompany($request, $user)
    {
        $user->role_id = 1;
        $user->save();

        $errors = $request->check($request);
        $data = $request->all();

        // No errors, Minimum one language filled
        if(!$errors){
            (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
            $data['slug'] = str_random(10);
            if($request->hasFile('img')){
                $width = Config::get('settings.addAdvertCompany.img.width');
                $height = Config::get('settings.addAdvertCompany.img.height');
                $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');
                $data['user_id'] = $user->id;

            }/*Article full image*/


        }
        $result = AdvertiserCompany::create($data);
        return $result;
    }


    public function addBookmark($ids, $auth_user_id)
    {
        $user = User::findOrfail($auth_user_id);
        if(isset($user)){
            if($ids){
                $user->bookmarkedAdvertComp()->sync($ids,false);
            }
        }
    }


    public function deleteBookmark($ids, $auth_user_id)
    {


        $user = User::findOrfail($auth_user_id);

        $user->bookmarkedAdvertComp()->detach($ids);
    }


    public function getUserBookmarks($user_id)
    {
        $user = User::findOrFail($user_id);
        return $user->bookmarkedAdvertComp()->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function addAdvertCompanyTranslate($request, $article_result)
    {
        $input = $request->all();
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
                $translate = AdvertiserCompanyTrans::create($data);

            }
        }
    }


    public function addAdvertCompanyIndustries($request, $obj)
    {
        $ids = isset($request->industries) ? $request->industries : null;
        if($ids){
            $obj->industries()->sync($ids);
        }
        return $obj;
    }



    public function updateAdvertCompany($request, $id)
    {
        $item = AdvertiserCompany::findOrFail($id);
        $errors = $request->check($request);
        $data = $request->all();

        //  dd($request->all());

        // No errors, Minimum one language filled
        if(!$errors){
            (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

            if($request->hasFile('img')){
                $width = Config::get('settings.addAdvertCompany.img.width');
                $height = Config::get('settings.addAdvertCompany.img.height');
                $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

            }/*Article full image*/
        }


        $result = $item->update($data);
        // $result = $item->update($data);

        return $result;

    }

    public function updateAdvertCompanyTranslate($request, $id)
    {

        $item = AdvertiserCompany::findOrFail($id);

        $input = $request->except('_token');
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data = [];

            $data['title'] = $input['title'][$localeCode];
            if (empty($data['title']) || $data['title'] == false) {
                $translate = AdvertiserCompanyTrans::where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();
                if ($translate) {
                    $translate->delete();
                    continue;
                }
            }
            else {
                $data['title'] = $input['title'][$localeCode];
                $data['lang'] = $localeCode;
                $data['slug_article'] = $item->slug;

                $translate = AdvertiserCompanyTrans::where(['slug_article' => $item->slug, 'lang' => $localeCode])->first();


                if ($translate) {
                    $translate->update($data);
                } else {
                    $translate = AdvertiserCompanyTrans::create($data);
                }
            }
        }
    }

    public function updateIndustries($request, $item_id)
    {
        $ids = $request->industries;
        $item = $this->model::findOrfail($item_id);
        if(isset($item)){
            if($ids){
                $item->industries()->sync($ids);
            }else{
                $item->industries()->detach();
            }
        }
    }

    public function deleteAdvertisersCompany($id)
    {
        $restCompany = AdvertiserCompany::findOrFail($id);
        $restCompany->user()->first()->delete();
        $restCompany->delete();
    }

    public function searchAdvertCompany($request)
    {
        if($request->ajax()){
            $output = '';

            $trans = DB::table('advertiser_companies_trans')
                ->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('id', $request->search)
                ->take(20)
                ->get();
            if($trans){
                foreach ($trans as $key=>$tran) {
                    $item = AdvertiserCompany::where(['slug' =>$tran->slug_article])->first();
                    $output .= '<a href='.route('admin.advertiserCompanies.getSearched', ['id' => $item->id]).'>'.$tran->title. '</a>' . '<br>';
                }

                return $output;
            }
        }
    }

    public function getAllAdvertCompanies()
    {
        return $this->model->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function createAdvertCompany($data)
    {
        return $this->model->create($data);
    }

    public function createAdvertCompanyTrans($data)
    {
        return $this->modelTrans->create($data);
    }

    public function getCompanyById($id)
    {
        return $this->model->where('id', $id)->first();
    }

}