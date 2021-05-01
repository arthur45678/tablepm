<?php

namespace App\Models;

use App\Models\Trans\RestaurantCompanyTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SearchRestaurant extends Model
{
    //     $query = "SELECT id, name, address, lat, lng, ( 3959 * acos( cos( radians('$center_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$center_lng') ) + sin( radians('$center_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '$radius' ORDER BY distance LIMIT 0 , 20";
    public static function findLocation($center_lat, $center_lng, $radius){
        return DB::table('markers')
            ->select('id', 'name', 'address', 'lat', 'lng',
                DB::raw( "( 3959 * acos( cos( radians('$center_lat') ) 
                  * cos( radians( lat ) ) * cos( radians( lng ) - radians('$center_lng') ) 
                  + sin( radians('$center_lat') ) 
                  * sin( radians( lat ) ) ) ) AS distance")
            )
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->limit(20)
            ->get();


        /*  return DB::select("SELECT id,  lat, lng, slug,
                          ( 3959 * acos( cos( radians(:center_lat1) )
                          * cos( radians( lat ) )
                          * cos( radians( lng ) - radians(:center_lng) )
                          + sin( radians(:center_lat2) )
                          * sin( radians( lat ) ) ) ) AS distance
                          FROM restaurant_companies
                          HAVING distance < :radius
                          ORDER BY distance LIMIT 0 , 20",
              [
                  'center_lat1' => $center_lat,
                  'center_lng' => $center_lng,
                  'center_lat2' => $center_lat,
                  'radius' => $radius
              ]);*/

    }

    public function findLocationTrans($slug, $lang = FALSE)
    {
        if(!$lang){$lang = App::getLocale();}

    }


}
