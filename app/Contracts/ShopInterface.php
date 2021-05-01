<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 6/5/2018
 * Time: 2:15 PM
 */

namespace App\Contracts;


interface ShopInterface
{
    public function addItem($request);
    public function updateItem($request, $id);
    public function addItemTranslate($request, $article_result);
    public function getByID($id);
}