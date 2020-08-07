<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DistrictsRepository;
use App\Models\RestaurantCompany;
use App\Models\Trans\RestaurantCompanyTrans;

use App\Repositories\CountriesRepository;
use App\Repositories\RestaurantCompanyRepository;
use App\Repositories\RestaurantShopProfileRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RestaurantCuisineRepository;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class RestaurantShopProfileController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $rest_shop_prof_rep;
    protected $countries_rep;
    protected $districts_rep;

    protected $restaurantCompaniesRep;

    public function __construct(RestaurantShopProfileRepository $rest_shop_prof_rep,
                                CountriesRepository $countries_rep,
                                DistrictsRepository $districts_rep,
                                RestaurantCompanyRepository $restaurantCompaniesRep,
                                UserContract $userRepo

    )
    {
        parent::__construct($userRepo);
        $this->rest_shop_prof_rep = $rest_shop_prof_rep;
        $this->countries_rep = $countries_rep;
        $this->districts_rep = $districts_rep;
        $this->restaurantCompaniesRep = $restaurantCompaniesRep;

    }

    public function searchRestaurant(Request $request)
    {
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }


        $s = $request->input('s');
        $articles = RestaurantCompanyTrans::latest()
            ->search($s)
            ->paginate(20);



        return view('admin.restaurantShopProfile.searchRestaurant')->with([
            'title' => 'Search restaurant',
            's' => $s,
            'articles' => $articles,
        ]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }

        return view('admin.restaurantShopProfile.index')->with([
            'title' => 'All restaurant shop profiles',
            'articles' => $this->rest_shop_prof_rep->getAll()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }

        $slug = $request->input('slug');


        return view('admin.restaurantShopProfile.create')->with([
            'title' => 'Create Restaurant shop profile',
            'parent_id' => RestaurantCompany::where(['slug' => $slug])->first()->id,
            'restaurant' => RestaurantCompany::where(['slug' => $slug])->first(),
            'countries' => $this->countries_rep->getAll(),
            'cuisines' => $this->rest_shop_prof_rep->getAllCuisines(),
            'dishes' => $this->rest_shop_prof_rep->getAllDishes(),
            'districts' => $this->districts_rep->getAllNoPagination(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }


        $article_result = $this->rest_shop_prof_rep->addItem($request);
        $this->rest_shop_prof_rep->addRestCuisines($request, $article_result);
        $this->rest_shop_prof_rep->addRestDishes($request, $article_result);
        $this->rest_shop_prof_rep->addItemTranslate($request, $article_result);

        return redirect()->route('admin.restaurantShopProfile.getRestaurantShopsByRestaurantID', ['id' => $request->parent_id])
            ->with([
                'success' => 'Created',
                'title' => 'All shop profiles',
                'restaurant' => $this->restaurantCompaniesRep->getByID($request->parent_id),
                'articles' => $this->rest_shop_prof_rep->getSertaurantShops($request->parent_id),
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        return view('admin.restaurantShopProfile.show')->with([
            'title' => 'Restaurant shop',
            'article' => $this->rest_shop_prof_rep->getByID($id),
            'countries' => $this->countries_rep->getAll(),
            'cuisines' => $this->rest_shop_prof_rep->getAllCuisines(),
            'dishes' => $this->rest_shop_prof_rep->getAllDishes(),
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
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }

        return view('admin.restaurantShopProfile.edit')->with([
            'title' => 'Edit restaurant shop',
            'article' => $this->rest_shop_prof_rep->getByID($id),
            'countries' => $this->countries_rep->getAll(),
            'cuisines' => $this->rest_shop_prof_rep->getAllCuisines(),
            'dishes' => $this->rest_shop_prof_rep->getAllDishes(),
            'districts' => $this->districts_rep->getAllNoPagination(),
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
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }

        $this->rest_shop_prof_rep->updateItem($request, $id);

        $this->rest_shop_prof_rep->updateRestShopDishes($request, $id);
        $this->rest_shop_prof_rep->updateRestShopCuisines($request, $id);

        $this->rest_shop_prof_rep->updateItemTranslate($request, $id);
        return redirect()->route('admin.restaurantShopProfile.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('RESTAURANT_SHOP_PROFILE')) {
            abort(403);
        }


        $this->rest_shop_prof_rep->deleteItem($id);
        return redirect()->route('admin.restaurantShopProfile.index')->with(['success' => 'Deleted']);
    }

    public function getRestaurantShopsByRestaurantID($restaurant_id){


        return view('admin.restaurantShopProfile.getRestaurantShopsByRestaurantID')->with([
            'title' => 'All shop profiles',
            'restaurant' => $this->restaurantCompaniesRep->getByID($restaurant_id),
            'articles' => $this->rest_shop_prof_rep->getSertaurantShops($restaurant_id),
        ]);

    }

    public function viewRestaurantShopsLocations()
    {

        $restaurantShops = $this->rest_shop_prof_rep->getRestaurantShopsLocations();

        return view('admin.restaurantShopProfile.viewRestaurantShopsLocations')->with([
            'title' => 'Restaurant shop location',
            'restaurantShops' => $restaurantShops,
        ]);
    }
}
