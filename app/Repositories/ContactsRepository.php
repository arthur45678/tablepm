<?php
/**
 * Created by PhpStorm.
 * User: ART
 * Date: 5/31/2018
 * Time: 2:57 PM
 */

namespace App\Repositories;


use App\Contracts\ContactsInterface;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mail;


class ContactsRepository implements ContactsInterface
{
    public function sendMessage($data){
        Mail::send('site.contacts.email', ['data' => $data], function ($message) use ($data) {
            $mail_admin = env('EMAIL_ADMIN');

            $message->from($data['email'], $data['name']);


            $message->to($mail_admin)->subject('text');
        });
    }
}