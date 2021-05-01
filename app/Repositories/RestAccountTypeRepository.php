<?php
namespace App\Repositories;


use App\Models\RestAccountType;
use App\Models\Trans\RestAccountTypeTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Contracts\RestAccountTypeContract;

class RestAccountTypeRepository implements RestAccountTypeContract
{
    /**
     * Object of RestAccountType class.
     *
     * @var $model 
     */
    private $model;

    /**
     * Create a new instance of RestAccountTypeRepository class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new RestAccountType(); 
    }

    /**
     * get all restaurant account types
     */
    public function getAllRestAccountTypes()
    {
        return $this->model->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function createRestAccountType($data)
    {
         //   $errors = $request->check($request);
       //  $data = $request->all();
         $obj = $this->model;

         // No errors, Minimum one language filled
         //  if(!$errors){
         (isset($data['status']) ? $data['status'] = 1 : $data['status'] = 0 );
         (isset($data['status']) ? $data['slug'] =  $this->model::createSlug($data['status']) : $data['slug'] = $this->model::createSlug());

         // }
         $result = $obj->create($data);
         return $result;
      //  return $this->model->create($data);
    }


    public function addItemTranslate($request, $article_result)
    {
        $input = $request->all();
        $translation = new RestAccountTypeTrans();
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

    public function updateItem($data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function updateItemTranslate($request, $id)
    {
        $item = $this->model::findOrFail($id);
        $translation = new RestAccountTypeTrans();

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

    public function getRestAccountTypeById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function deleteItem($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getAllNoPagination()
    {
        $this->model->get();
    }

}