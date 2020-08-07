<?php

namespace App\Http\Controllers\Site;

use App\Models\RestaurantShopProfile;
use App\Repositories\RestaurantShopProfileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CountriesRepository;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BookmarkedController extends SiteController
{
    private $restShopRepository;

    public function __construct(RestaurantShopProfileRepository $restShopRepository)
    {
        parent::__construct();
        $this->restShopRepository = $restShopRepository;
    }


    public function addRestaurantShopBookmark($ids)
    {


        $this->restShopRepository->addBookmark($ids, Auth::user()->id);

        return redirect()->back()->with(['success' => 'Added']);
    }

    public function getRestaurantShopBookmarked()
    {

        return view('site.bookmarked.getRestaurantShopsBookmarked')->with([
            'title' => 'All bookmarked restaurants',
            'articles' => $this->restShopRepository->getUserBookmarks(Auth::user()->id),
        ]);
    }

    public function deleteRestaurantShopBookmarked($ids)
    {

        $this->restShopRepository->deleteBookmark($ids, Auth::user()->id);
        return redirect()->back()->with(['success' => 'Updated']);
    }

}
