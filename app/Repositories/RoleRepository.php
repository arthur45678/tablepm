<?php

namespace App\Repositories;

use App\Contracts\RolesInterface;
use App\Models\Role;
use App\Contracts\RoleContract;
use Illuminate\Support\Facades\Config;

class RoleRepository implements RoleContract
{

    /**
     * Object of Role class.
     *
     * @var $model 
     */
    private $model;

    /**
     * Create a new instance of RoleRepository class.
     *
     * @return void
     */

    public function getAll()
    {
        return $this->model::orderBy(
            'id', Config::get('settings.admin.articles.orderBy')
        )->paginate(Config::get('settings.admin.articles.paginate'));

    }


    public function __construct()
    {
        $this->model = new Role(); 
    }

    /**
     * get all roles
     */
    public function getRoles()
    {
        return $this->model->paginate(Config::get('settings.admin.articles.paginate'));
    }

    public function getRoleByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

}