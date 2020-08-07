<?php

namespace App\Http\Controllers\Admin;

use App\Models\RestaurantCompany;
use App\Repositories\AdvertiserCompanyRepository;
use App\Repositories\RestaurantCompanyRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class BookmarkedController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $restaurants_comp_rep;
    protected $advert_comp_rep;

    public function __construct(UserContract $userRepo)
    {
        parent::__construct($userRepo);
    }


    public function addRestaurantCompaniesBookmark($ids)
    {

        /*
         * $this->advert_comp_rep = new AdvertiserCompanyRepository();
        $this->advert_comp_rep->addBookmark($ids, Auth::user()->id);

        return redirect()->back()->with(['success' => 'Updated']);
         *
         * */

       $this->restaurants_comp_rep = new RestaurantCompanyRepository();
       $this->restaurants_comp_rep->addBookmark($ids, Auth::user()->id);

       return redirect()->back()->with(['success' => 'Updated']);
    }

    public function getRestaurantCompaniesBookmarked()
    {
        $this->restaurants_comp_rep = new RestaurantCompanyRepository();

        return view('admin.bookmarked.getRestaurantCompaniesBookmarked')->with([
            'title' => 'All bookmarked restaurants',
            'articles' => $this->restaurants_comp_rep->getUserBookmarks(Auth::user()->id),
        ]);



    }

    public function deleteRestaurantCompaniesBookmarked($ids)
    {
        $this->restaurants_comp_rep = new RestaurantCompanyRepository();
        $this->restaurants_comp_rep->deleteBookmark($ids, Auth::user()->id);
        return redirect()->back()->with(['success' => 'Updated']);
    }


    public function addAdvertiserCompaniesBookmark($ids)
    {
        $this->advert_comp_rep = new AdvertiserCompanyRepository();
        $this->advert_comp_rep->addBookmark($ids, Auth::user()->id);

        return redirect()->back()->with(['success' => 'Updated']);
    }

    public function getAdvertiserCompaniesBookmarked()
    {
        $this->advert_comp_rep = new AdvertiserCompanyRepository();

        return view('admin.bookmarked.getAdvertisersCompaniesBookmarked')->with([
            'title' => 'Bookmarked advertisers companies',
            'articles' => $this->advert_comp_rep->getUserBookmarks(Auth::user()->id),
        ]);

    }

    public function deleteAdvertiserCompaniesBookmarked($ids)
    {
        $this->advert_comp_rep = new AdvertiserCompanyRepository();
        $this->advert_comp_rep->deleteBookmark($ids, Auth::user()->id);
        return redirect()->back()->with(['success' => 'Updated']);
    }

}
