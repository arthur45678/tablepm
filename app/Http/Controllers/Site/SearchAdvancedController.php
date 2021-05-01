<?php

namespace App\Http\Controllers\Site;

use App\Contracts\UserContract;
use App\Models\RestaurantShopProfile;
use App\Repositories\RestaurantTypeRepository;
use App\Models\Trans\RestaurantCompanyTrans;
use App\Repositories\DistrictsRepository;
use App\Repositories\RestAccountTypeRepository;
use App\Http\Requests\RestaurantCompaniesRequest;
use App\Models\RestaurantCompany;
use App\Repositories\CustomerTypeRepository;
use App\Repositories\RestaurantCompanyRepository;
use App\Repositories\RestaurantCuisineRepository;
use App\Repositories\SearchRestaurantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CountriesRepository;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class SearchAdvancedController extends SiteController
{
    protected $rest_comp_rep;
    protected $countries_rep;
    protected $customer_types_rep;
    protected $rest_account_type_rep;
    protected $users_rep;
    protected $districts_rep;
    protected $rest_cuisine_rep;
    protected $rest_type_rep;
    protected $search_rest_rep;


    public function __construct(RestaurantCompanyRepository $rest_comp_rep, CountriesRepository $countries_rep,
                                CustomerTypeRepository $customer_types_rep,
                                RestAccountTypeRepository $rest_account_type_rep,
                                UserContract $users_rep, DistrictsRepository $districts_rep,
                                RestaurantCuisineRepository $rest_cuisine_rep,
                                RestaurantTypeRepository $rest_type_rep,
                                SearchRestaurantRepository $search_rest_rep

                    )
    {
        parent::__construct();
        $this->rest_comp_rep = $rest_comp_rep;
        $this->countries_rep = $countries_rep;
        $this->customer_types_rep = $customer_types_rep;
        $this->rest_account_type_rep = $rest_account_type_rep;
        $this->users_rep = $users_rep;
        $this->districts_rep = $districts_rep;
        $this->rest_cuisine_rep = $rest_cuisine_rep;
        $this->rest_type_rep = $rest_type_rep;
        $this->search_rest_rep = $search_rest_rep;

    }

    public function index()
    {

        return view('site.search.index')->with([
            'title' => 'Create Restaurant company',
            'countries' => $this->countries_rep->getAllNoPagination(),
            'districts' => $this->districts_rep->getAllNoPagination(),
            'customerTypes' => $this->customer_types_rep->getAllNoPagination(),

            'cuisines' => $this->rest_cuisine_rep->getAllNoPagination(),
            'restaurantType' => $this->rest_type_rep->getAllNoPagination(),
        ]);
    }

    public function show(Request $request)
    {

        $query = $this->search_rest_rep->advancedSearch($request);


        return view('site.search.advancesSearchResult')
            ->with([
                'title' => 'Search result',
                'articles' => $query->paginate(15),
            ]);



    }


    public function searchByDistrict(Request $request)
    {

        return view('site.search.searchByDistrict')
            ->with([
                'articles' => $this->search_rest_rep->searchByDistrict($request)->paginate(15),
            ]);
    }
}
