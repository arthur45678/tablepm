<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/16/2018
 * Time: 4:26 PM
 */

namespace App\Repositories;

use App\Models\TasksForAdvertCompanies;
use App\Models\Trans\TasksForAdvertCompaniesTrans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TasksAdvertsCompaniesRepository extends Repository
{
    public function __construct()
    {
        $this->model = new TasksForAdvertCompanies();
    }



    public function addItem($request)
    {
        //   $errors = $request->check($request);
        $data = $request->all();
        $obj = $this->model;

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );
        (isset($request->slug) ? $data['slug'] = self::createSlug($request->slug) : $data['slug'] = self::createSlug());
        $data['user_id'] = Auth::user()->id;

        if($request->hasFile('img')){
            $width = Config::get('settings.restaurantCompany.img.width');
            $height = Config::get('settings.restaurantCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/


        // }
        $result = $obj->create($data);
        return $result;
    }



    public function updateItem($request, $id)
    {
        $item = $this->model::findOrFail($id);
        //   $errors = $request->check($request);
        $data = $request->all();

        //  dd($request->all());

        // No errors, Minimum one language filled
        //  if(!$errors){
        (isset($request->status) ? $data['status'] = 1 : $data['status'] = 0 );

        if($request->hasFile('img')){
            $width = Config::get('settings.addAdvertCompany.img.width');
            $height = Config::get('settings.addAdvertCompany.img.height');
            $data['img'] = ImageOptimization::imageCropSave($request->file('img'), $width, $height,  public_path().'/images/');

        }/*Article full image*/
        //    }


        $result = $item->update($data);
        // $result = $item->update($data);

        return $result;
    }



}