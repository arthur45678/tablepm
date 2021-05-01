<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 6/1/2018
 * Time: 5:14 PM
 */

namespace App\Contracts;


interface RestaurantShopProfileInterface
{

    public function addBookmark($ids, $auth_user_id);

    public function deleteBookmark($ids, $auth_user_id);

    public function getUserBookmarks($user_id);


    public function addItem($request);
    public function updateItem($request, $id);
    public function addItemTranslate($request, $article_result);
    public function addRestDishes($request, $obj);
    public function getByID($id);

    public function addRestCuisines($request, $obj);



    public function updateItemTranslate($request, $id);

    public function updateRestShopDishes($request, $item_id);
    public function updateRestShopCuisines($request, $item_id);
    public function getAllCuisines();
    public function getAllDishes();

}