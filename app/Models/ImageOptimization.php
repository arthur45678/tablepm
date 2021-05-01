<?php

namespace App\Models;

use Image;
use Illuminate\Database\Eloquent\Model;

class ImageOptimization extends Model
{
    public static function imageCropSave($imageRequestFile, $width, $height, $path, $setSaveName = false)
    {
        if(!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        if($imageRequestFile->isValid()){
            $str = str_random(8);
            $obj = new \stdClass;

            if($setSaveName){
                $obj->post_img = $setSaveName;
            }else{
                $obj->post_img = $str.'_' . $imageRequestFile->getClientOriginalName();
            }
            $img = Image::make($imageRequestFile);
            $img->fit($width, $height)
                ->save($path. '/'. $obj->post_img);
        }
        return $obj->post_img;
    }


    public static function imageCropAndResizeSave($imageRequestFile, $width = false, $height = false, $path, $setSaveName = false)
    {
        // Srancic meknumek@ FALSE piti lini ($width, $height)
        if($width && $height){
            return 'Set value only one (width or height)';
        }

        if(!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        if($imageRequestFile->isValid()){
            $str = str_random(8);
            $obj = new \stdClass;

            if($setSaveName){
                $obj->post_img = $setSaveName;
            }else{
                $obj->post_img = $str.'_' . $imageRequestFile->getClientOriginalName();
            }
            $img = Image::make($imageRequestFile);

            if($width){
                $img->widen($width);
            }
            if($height){
                $img->heighten($height);
            }
            $img->save($path. '/'. $obj->post_img);

        }
        return $obj->post_img;
    }

    public static function imageStoreNoOptimize($file, $path, $name = false)
    {

        if(!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        if($file->isValid()){
            $str = str_random(8);

            if($name == false){
               $name = $str.'_' . $file->getClientOriginalName();
            }

            $file->move($path, $name);
            return $name;
        }
    }

    public static function imageResizeOnlyTheWidth($imageRequestFile, $width, $path, $setSaveName = false)
    {
        if(!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        if($imageRequestFile->isValid()){
            $str = str_random(8);
            $obj = new \stdClass;

            if($setSaveName){
                $obj->post_img = $setSaveName;
            }else{
                $obj->post_img = $str.'_' . $imageRequestFile->getClientOriginalName();
            }
            $img = Image::make($imageRequestFile);

            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            }
            )->save($path. '/'. $obj->post_img);
        }
        return $obj->post_img;
    }

     public static function imageResizeOnlyTheHeight($imageRequestFile, $height, $path, $setSaveName = false)
     {
        if(!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        if($imageRequestFile->isValid()){
            $str = str_random(8);
            $obj = new \stdClass;

            if($setSaveName){
                $obj->post_img = $setSaveName;
            }else{
                $obj->post_img = $str.'_' . $imageRequestFile->getClientOriginalName();
            }
            $img = Image::make($imageRequestFile);

            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            }
            )->save($path. '/'. $obj->post_img);
        }
        return $obj->post_img;
    }


}
