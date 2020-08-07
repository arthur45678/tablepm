<?php

namespace App\Http\Controllers\Advertisers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertisersController extends Controller
{
    protected $vars = [];
    protected $template;

    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $user;


    public function __construct()
    {

    }

    public function renderOutput()
    {
        $sidebar = $this->getSidebar();
        $this->vars = array_add($this->vars, 'sidebar', $sidebar);

        $this->vars = array_add($this->vars, 'title', $this->title);
        return view($this->template)->with($this->vars);
    }


    public function getSidebar()
    {
        return view('advertisers.includes.sidebar');
    }
}
