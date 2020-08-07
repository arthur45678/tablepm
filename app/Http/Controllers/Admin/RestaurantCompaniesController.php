<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\RestaurantShopProfileInterface;
use App\Repositories\RestaurantShopProfileRepository;
use App\Repositories\RestaurantTypeRepository;
use App\Models\Trans\RestaurantCompanyTrans;
use App\Repositories\DistrictsRepository;
use App\Repositories\RestAccountTypeRepository;
use App\Http\Requests\RestaurantCompaniesRequest;
use App\Models\RestaurantCompany;
use App\Repositories\CustomerTypeRepository;
use App\Repositories\RestaurantCompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CountriesRepository;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class RestaurantCompaniesController extends AdminController
{

    protected $rest_comp_rep;
    protected $countries_rep;
    protected $customer_types_rep;
    protected $rest_account_type_rep;
    protected $users_rep;
    protected $districts_rep;
    protected $rest_type_rep;
    protected $restShopProfRepository;


    public function __construct(RestaurantCompanyRepository $rest_comp_rep, CountriesRepository $countries_rep,
                                CustomerTypeRepository $customer_types_rep, RestAccountTypeRepository $rest_account_type_rep,
                                UserRepository $users_rep, DistrictsRepository $districts_rep,
                                RestaurantTypeRepository $rest_type_rep,
                                RestaurantShopProfileInterface $restShopProfRepository
                    )
    {
        parent::__construct($users_rep);
        $this->rest_comp_rep = $rest_comp_rep;
        $this->countries_rep = $countries_rep;
        $this->customer_types_rep = $customer_types_rep;
        $this->rest_account_type_rep = $rest_account_type_rep;
        $this->users_rep = $users_rep;
        $this->districts_rep = $districts_rep;
        $this->rest_type_rep = $rest_type_rep;
        $this->restShopProfRepository = $restShopProfRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }


        return view('admin.restaurantcompanies.index')->with([
            'title' => 'All restaurant companies',
            'articles' => $this->rest_comp_rep->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }


        return view('admin.restaurantcompanies.create')->with([
            'countries' => $this->countries_rep->getAllNoPagination(),
            'districts' => $this->districts_rep->getAllNoPagination(),
            'customerTypes' => $this->customer_types_rep->getAllNoPagination(),
            'accountTypes' => $this->rest_account_type_rep->getAllNoPagination(),
            'restaurantType' => $this->rest_type_rep->getAllNoPagination(),
            'title' => 'Create Restaurant company',

        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantCompaniesRequest $request)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }

        $data = $request->data($request);

        $user = $this->users_rep->addUser($data);

        $article_result = $this->rest_comp_rep->addRestaurantCompany($request, $user);
        $this->rest_comp_rep->addCustomerTypes($request, $article_result);
        $this->rest_comp_rep->addRestaurantTypes($request, $article_result);
        $this->rest_comp_rep->addRestaurantCompanyTranslate($request, $article_result);

        return redirect()->route('admin.RestaurantCompanies.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }

        return view('admin.restaurantcompanies.show')->with([
            'title' => 'Restaurant company',
            'countries' => $this->countries_rep->getAll(),
            'article' => $this->rest_comp_rep->getByID($id),
            'districts' => $this->districts_rep->getAllNoPagination(),

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }

        $article = $this->rest_comp_rep->getByID($id);

        return view('admin.restaurantcompanies.edit')->with([
            'title' => 'Edit restaurant company',
            'countries' => $this->countries_rep->getAll(),
            'article' => $article,
            'customerTypes' => $this->customer_types_rep->getAllNoPagination(),
            'districts' => $this->districts_rep->getAllNoPagination(),
            'accountTypes' => $this->rest_account_type_rep->getAllNoPagination(),
            'restaurantType' => $this->rest_type_rep->getAllNoPagination(),
            'user' => $this->users_rep->getUserById($article->user_id),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }


        $this->rest_comp_rep->updateRestaurantCompany($request, $id);
        $this->rest_comp_rep->updateCustomerTypes($request, $id);
        $this->rest_comp_rep->updateRestaurantTypes($request, $id);

        $this->rest_comp_rep->updateRestaurantCompanyTranslate($request, $id);

        $this->users_rep->updateRestaurantCompanyUser($request, $id);

        return redirect()->route('admin.RestaurantCompanies.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('RESTAURANT_COMPANIES')) {
            abort(403);
        }
        //   $this->rest_comp_rep->deleteItem($id);
        $this->rest_comp_rep->deleteRestaurantCompany($id);
        return redirect()->route('admin.RestaurantCompanies.index')->with(['success' => 'Deleted']);
    }


    public function search(Request $request)
    {
        $result = $this->rest_comp_rep->searchRestaurantCompany($request);
        return response($result);
     }

    public function getSearched($id)
    {

        return view('admin.restaurantcompanies.getSearched')->with([
            'article' => $this->rest_comp_rep->getByID($id),
            'title' => 'Get searched',

        ]);
    }

    public function viewRestaurantLocations()
    {


        $restaurants = $this->rest_comp_rep->getAllRestaurantLocations();


        return view('admin.restaurantcompanies.viewRestaurantLocations')
            ->with(['restaurants' => $restaurants]);


    }

    public function getAllRestaurantLocations()
    {
        $this->rest_comp_rep->getAllRestaurantLocations();


    }
    
    public function showAllRestaurantLocations($sendData)
    {

       $result = $this->rest_comp_rep->showAllRestaurantLocations($sendData);

       echo $result;
    }



}
