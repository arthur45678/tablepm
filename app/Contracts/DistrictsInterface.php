<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 6/5/2018
 * Time: 2:55 PM
 */

namespace App\Contracts;


interface DistrictsInterface
{
    public function getAll();
    public function getAllNoPagination();

    public function addItem($request);
    public function updateItem($request, $id);
    public function addItemTranslate($request, $article_result);
    public function getByID($id);

}