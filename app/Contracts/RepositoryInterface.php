<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 4/13/2018
 * Time: 12:47 PM
 */

namespace App\Contracts;


interface RepositoryInterface
{
    public function getAll();

    public function getByID($id);

    public function deleteItem($id);

    public function getAllNoPagination();
}