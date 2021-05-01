<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\RestaurantTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class RestaurantTypeController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $rest_type_rep;

    public function __construct(RestaurantTypeRepository $rest_type_rep, UserContract $userRepo)
    {
        parent::__construct($userRepo);
        $this->rest_type_rep = $rest_type_rep;

    }

    //admin.restaurantType
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }



        return view('admin.restaurantType.index')
            ->with([
                'title' => 'All restaurant types',
                'articles' => $this->rest_type_rep->getAll(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        return view('admin.restaurantType.create')->with([
            'title' => 'Create restaurant type',
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
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        // $this->rest_type_rep->addItem($request);

        $article_result = $this->rest_type_rep->addItem($request);
        $this->rest_type_rep->addItemTranslate($request, $article_result);

        return redirect()->route('admin.restaurantType.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        return view('admin.restaurantType.show')->with([
            'title' => 'Restaurant type',
            'article' => $this->rest_type_rep->getByID($id),
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
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        return view('admin.restaurantType.edit')->with([
            'title' => 'Edit restaurant type',
            'article' => $this->rest_type_rep->getByID($id),
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
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        $this->rest_type_rep->updateItem($request, $id);
        $this->rest_type_rep->updateItemTranslate($request, $id);
        return redirect()->route('admin.restaurantType.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('RESTAURANT_TYPE')) {
            abort(403);
        }

        $this->rest_type_rep->deleteItem($id);
        return redirect()->route('admin.restaurantType.index')->with(['success' => 'Deleted']);
    }
}
