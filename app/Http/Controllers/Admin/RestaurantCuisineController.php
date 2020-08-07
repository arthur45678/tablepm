<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DishRepository;
use App\Repositories\RestaurantCompanyRepository;
use App\Repositories\RestaurantCuisineRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class RestaurantCuisineController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $rest_cuisine_rep;

    public function __construct(RestaurantCuisineRepository $rest_cuisine_rep, UserContract $userRepo)
    {
        parent::__construct($userRepo);
        $this->rest_cuisine_rep = $rest_cuisine_rep;

    }

    //admin.restaurantcuisine
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }



        return view('admin.restaurantcuisine.index')
            ->with([
                'title' => 'All restaurant cuisines',
                'articles' => $this->rest_cuisine_rep->getAll(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

        return view('admin.restaurantcuisine.create')->with([
            'title' => 'Create restaurant cuisine',
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
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

       // $this->rest_cuisine_rep->addItem($request);

        $article_result = $this->rest_cuisine_rep->addItem($request);
        $this->rest_cuisine_rep->addItemTranslate($request, $article_result);

        return redirect()->route('admin.restaurantcuisine.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

        return view('admin.restaurantcuisine.show')->with([
            'title' => 'Restaurant cuisine',
            'article' => $this->rest_cuisine_rep->getByID($id),
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
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

        return view('admin.restaurantcuisine.edit')->with([
            'title' => 'Edit restaurant cuisine',
            'article' => $this->rest_cuisine_rep->getByID($id),
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
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

        $this->rest_cuisine_rep->updateItem($request, $id);
        $this->rest_cuisine_rep->updateItemTranslate($request, $id);
        return redirect()->route('admin.restaurantcuisine.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('RESTAURANT_CUISINE')) {
            abort(403);
        }

        $this->rest_cuisine_rep->deleteItem($id);
        return redirect()->route('admin.restaurantcuisine.index')->with(['success' => 'Deleted']);
    }
}
