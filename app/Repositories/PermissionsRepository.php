<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/13/2018
 * Time: 10:56 AM
 */

namespace App\Repositories;


use App\Contracts\PermissionsInterface;
use App\Models\Permission;
use App\Models\Role;

class PermissionsRepository extends Repository
{

    public function __construct()
    {
        $this->model = new Permission();
    }
    
    public static function changePermissions ($request) {

        $permission = Permission::where(['name' => 'VIEW_ADMIN'])->get();

        $data = $request->except('_token');

        $roles = Role::all();

        foreach($roles as $value) {
            if(isset($data[$value->id])) {
                $value->savePermissions($data[$value->id]);
            }

            else {
                $value->savePermissions([]);
            }
        }

        return ['status' => 'Права обновлены'];
    }

    public function getAll()
    {
        return $this->model::all();
    }

}