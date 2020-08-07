<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\Cources;
use App\Models\Menu;
use App\Models\Trans\CategoryTranslation;
use App\Models\Trans\CourcesTranslation;
use App\Models\Trans\EventTranslations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Setting;


class SiteController extends Controller
{
    protected $vars = [];
    protected $template;

    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $page_image;

    protected $publicPath;
    protected $imagePath;

    public function __construct()
    {
        view()->share([
            'assetPath' => asset('site'),
            'imagePath' => asset('images'),
            'imagesServe' => asset('imagesServe'),
        ]);
    }


}
