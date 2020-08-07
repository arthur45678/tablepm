<?php

namespace App;

use App\Models\AdvertiserCompany;
use App\Models\RestaurantCompany;
use App\Models\RestaurantShopProfile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_name', 'email', 'password', 'role_id', 'is_active', 'name', 'country_code', 'phone_number', 'authy_id', 'confirmed', 'token', 'provider', 'provider_id', 'seen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function fullNumber()
    {
        return '+' . $this->country_code . $this->phone_number;
    }

    public function bookmarkedRestaurants()
    {
        return $this->belongsToMany(RestaurantCompany::class, 'bookmarked_restaurants', 'user_id', 'rest_comp_id');
    }

    public function bookmarkedAdvertComp()
    {
        return $this->belongsToMany(AdvertiserCompany::class, 'bookmark_advertisercompanies', 'user_id', 'advert_comp_id');
    }

    public function bookmarkedRestaurantShop()
    {
        return $this->belongsToMany(RestaurantShopProfile::class, 'bookmarked_restaurantShopProfiles', 'user_id', 'restShop_id');
    }



    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }




    // Permission - может быть как строка, так и массив, массив -это набор разрешений ('VIEW_ADMIN', 'ADD_ARTICLES').
    //* $require - данный параметр актуален, когда передается массив, $require вернет true только тогда,
    //   когда у пользователья есть каждая права в массиве
    // $require = true - вернет true только тогда, когда у пользователья есть каждое право в массиве
    // $require = FALSE - вернет true, если у пользователья есть хотья бы одно из прав массива.
    public function canDo($permission, $require = FALSE) {
        if(is_array($permission)) {
            foreach($permission as $permName) {

                $permName = $this->canDo($permName);
                if($permName && !$require) {
                    return TRUE;
                }
                else if(!$permName  && $require) {
                    return FALSE;
                }
            }

            return  $require;
        }
        else {
            foreach($this->roles as $role) {
                foreach($role->permissions as $perm) {
                    //foo*    foobar
                    if(str_is($permission,$perm->name)) {
                        return TRUE;
                    }
                }
            }
        }
    }


    // Возвращает истину, если пользователь привязен к определенной роли
    // Принимает роль либо в виде строки, либо массив ролей
    // $require = true вернет истину, если пользователь имеет все роли в массиве
    // $require = FALSE - вернет истину, если хотья бы одна роль есть из мпассива
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }



}
