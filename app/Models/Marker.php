<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Marker extends Model
{

    //     $query = "SELECT id, name, address, lat, lng, ( 3959 * acos( cos( radians('$center_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$center_lng') ) + sin( radians('$center_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '$radius' ORDER BY distance LIMIT 0 , 20";
    public static function findLocation($center_lat, $center_lng, $radius){


      /*Worked
       *   return DB::select("SELECT id, name, address, lat, lng,
                        ( 3959 * acos( cos( radians(:center_lat1) ) 
                        * cos( radians( lat ) ) 
                        * cos( radians( lng ) - radians(:center_lng) ) 
                        + sin( radians(:center_lat2) ) 
                        * sin( radians( lat ) ) ) ) AS distance 
                        FROM markers 
                        HAVING distance < :radius 
                        ORDER BY distance LIMIT 0 , 20",
            [
                'center_lat1' => $center_lat,
                'center_lng' => $center_lng,
                'center_lat2' => $center_lat,
                'radius' => $radius
            ]);*/

        return DB::select("SELECT id, name, address, lat, lng,
                        ( 3959 * acos( cos( radians(:center_lat1) ) 
                        * cos( radians( lat ) ) 
                        * cos( radians( lng ) - radians(:center_lng) ) 
                        + sin( radians(:center_lat2) ) 
                        * sin( radians( lat ) ) ) ) AS distance 
                        FROM markers 
                        HAVING distance < :radius 
                        ORDER BY distance LIMIT 0 , 20",
            [
                'center_lat1' => $center_lat,
                'center_lng' => $center_lng,
                'center_lat2' => $center_lat,
                'radius' => $radius
            ]);

    }
}


//     "SELECT id, name, address, lat, lng,
// ( 3959 * acos( cos( radians('$center_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$center_lng') ) + sin( radians('$center_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '$radius' ORDER BY distance LIMIT 0 , 20";


// select `id, name, address, lat, lng,
//( 3959 * acos( cos( radians('-33`.`737885') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('151`.`23526') ) + sin( radians('-33`.`737885') ) * sin( radians( lat ) ) ) )` as `distance` from `markers` having `1` = order by `distance` asc limit 0