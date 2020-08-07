<?php

namespace App\Http\Controllers\Site;

use App\Repositories\CountriesRepository;
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
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;


class IndexController extends SiteController
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


    public function __construct(RestaurantCompanyRepository $rest_comp_rep,
                                CountriesRepository $countries_rep,
                           //     CustomerTypeRepository $customer_types_rep,
                 //               RestAccountTypeRepository $rest_account_type_rep,
                              //  UserRepository $users_rep,
                                 DistrictsRepository $districts_rep,
                               // RestaurantCuisineRepository $rest_cuisine_rep,
                           //     RestaurantTypeRepository $rest_type_rep,
                                SearchRestaurantRepository $search_rest_rep

    )
    {
        parent::__construct();
        $this->rest_comp_rep = $rest_comp_rep;
        $this->countries_rep = $countries_rep;
        $this->districts_rep = $districts_rep;

        $this->search_rest_rep = $search_rest_rep;

    }

    public function index()
    {


        return view( 'site.home.index')
            ->with([
                    'articles' => $this->rest_comp_rep->getLatestsRestaurantsShopsOnlyTranslates(App::getLocale(), 6),
                    'districtsTrans' => $this->districts_rep->getOnlyTranslation(),
                ]
            );
    }



}
