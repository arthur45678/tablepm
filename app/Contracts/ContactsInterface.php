<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 5/31/2018
 * Time: 2:33 PM
 */

namespace App\Contracts;


interface ContactsInterface
{
    public function sendMessage($data);

}