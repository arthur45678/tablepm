<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/30/2018
 * Time: 2:57 PM
 */

namespace App\Repositories;
use App\User;
use App\Models\AdvertiserCompany;
use App\Models\Trans\AdvertiserCompanyTrans;

use App\Models\CustomerTypeRestaurants;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\Registered;

use App\Models\Trans\CustomerTypeRestaurantsTrans;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Twilio\Rest\Client;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterAdvertisersUserRepository extends Repository
{
    public function __construct()
    {
        $this->model = new CustomerTypeRestaurants();
    }

    public function createByEmail(array $data)
    {
        //return User::create([])
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'token' => str_random(25),
        ]);
        
        $item = AdvertiserCompany::create([
            'user_id' => $user->id,
            'slug' => self::createSlug(),
        ]);

        AdvertiserCompanyTrans::create([
            'title' => $data['title'],
            'slug_article' => $item->slug,
            'lang' => App::getLocale(),
        ]);

        return $user;
    }

    public function createByPhone(array $data)
    {
        //return User::create([])
        $user = User::create([
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'token' => str_random(25),
        ]);

        $item = AdvertiserCompany::create([
            'user_id' => $user->id,
            'slug' => self::createSlug(),
        ]);



        return $user;
    }



}