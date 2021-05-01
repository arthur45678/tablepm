<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 5/31/2018
 * Time: 4:03 PM
 */

namespace App\Contracts;


interface CountriesInterface
{

    public function getAll();
    public function getAllNoPagination();
}