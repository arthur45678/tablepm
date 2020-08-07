<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\UserContract;

class AdminController extends Controller
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $vars = [];
    protected $template;

    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $user;


    public function __construct($userRepo)
    {
        $newUsersCount = $userRepo->getNewUsersCount();
        view()->share([
            'imagePath' => asset('images'),
            'imagesServe' => asset('imagesServe'),
            'assetPath' => asset('admin'),
            'newUsersCount' => $newUsersCount
        ]);

    }

   /* public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);
        return view($this->template)->with($this->vars);
    }*/


}
