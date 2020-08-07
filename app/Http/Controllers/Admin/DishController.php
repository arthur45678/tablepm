<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DishRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class DishController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $dishes_rest_rep;

    public function __construct(DishRepository $dishes_rest_rep, UserContract $userRepo)
    {
        parent::__construct($userRepo);
        $this->dishes_rest_rep = $dishes_rest_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }

        return view('admin.dish.index')->with([
            'title' => 'All dishes',
            'articles' => $this->dishes_rest_rep->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }

        return view('admin.dish.create')->with([
            'title' => 'Create dish'
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
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }

        $article_result = $this->dishes_rest_rep->addDish($request);
        $this->dishes_rest_rep->addDishTranslate($request, $article_result);
        return redirect()->route('admin.dish.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }
        
        return view('admin.dish.show')->with([
            'title' => 'Dish',
            'article' => $this->dishes_rest_rep->getByID($id)
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
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }



        return view('admin.dish.edit')->with([
            'title' => 'Edit dish',
            'article' => $this->dishes_rest_rep->getByID($id),
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
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }

        $this->dishes_rest_rep->updateDish($request, $id);
        $this->dishes_rest_rep->updateDishTranslate($request, $id);

        $this->dishes_rest_rep->updateDish($request, $id);
        return redirect()->route('admin.dish.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('ADD_DISH_FOR_RESTAURANTS')) {
            abort(403);
        }

        $this->dishes_rest_rep->deleteItem($id);
        return redirect()->route('admin.dish.index')->with(['success' => 'Deleted']);
    }
}
