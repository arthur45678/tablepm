<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/13/2018
 * Time: 11:13 AM
 */

namespace App\Repositories;


use App\Contracts\ContactsInterface;
use App\Contracts\CountriesInterface;
use App\Models\Country;

class CountriesRepository  implements CountriesInterface
{

    /**
     * Object of CustomerTypeRestaurants class.
     *
     * @var $model
     */
    private $model;

    /**
     * Create a new instance of CustomerTypeRepository class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Country();
    }



    public function getAll()
    {
        return $this->model->orderBy('id', 'ASC')->get();
    }

    public function getAllNoPagination()
    {
        return $this->model::all();
    }



}