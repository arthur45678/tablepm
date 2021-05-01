<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class IndexController extends AdminController
{
	/**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    public function __construct(UserContract $userRepo)
    {
        parent::__construct($userRepo);
    }

    public function index()
    {

        $this->title = 'Admin Dashboard';
        $this->vars = array_add($this->vars, $this->title, 'title');

        return view('admin.home.index');
    }
}
