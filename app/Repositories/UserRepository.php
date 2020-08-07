<?php

namespace App\Repositories;

use App\Contracts\PermissionsInterface;
use App\Contracts\UsersInterface;
use App\Models\AdvertiserCompany;
use App\Models\RestaurantCompany;
use App\User;
use Illuminate\Support\Facades\Config;
use App\Contracts\UserContract;

class UserRepository implements UserContract
{

    /**
     * Object of User class.
     *
     * @var $model 
     */
    private $model;

    /**
     * Create a new instance of UserRepository class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User(); 
    }

    /**
     * Get all users
     */
    public function getUsers()
    {
        return $this->model->paginate(Config::get('settings.admin.articles.paginate'));
    }

    /**
     * Add user
     */
    public function addUser($data)
    {
        return $this->model->create($data);
    }

    /**
     * Get user by id
     *
     * @param int $id
     */
    public function getUserById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * delete user
     *
     * @param int $id
     */
    public function deleteUser($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * edit user
     *
     * @param array $data
     * @param int $id
     */
    public function updateUser($user, $data)
    {
        return $user->update($data);
    }



    public function updateAdvertUser($request, $advertCompany_id)
    {
        $user = AdvertiserCompany::findOrFail($advertCompany_id)->user()->first();
        if($user) {
            $data = $request->except('password');
            if(isset($request->password)) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return $user;
        }
        
    }


    public function updateRestaurantCompanyUser($request, $restCompany_id)
    {
        $user = RestaurantCompany::findOrFail($restCompany_id)->user()->first();

        $data = $request->except('password');
        if(isset($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return $user;
    }

    public function getNewAdvertisers()
    {
        return $this->model->where('role_id', 4)->where('seen', 0)->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function getNewUsersCount()
    {
        return $this->model->where('role_id', 4)->where('seen', 0)->count();
    }

}