<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CountriesInterface;
use App\Contracts\DistrictsInterface;
use App\Http\Requests\ShopRequest;
use App\Repositories\ShopRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;


class ShopsController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $shopRep;
    protected $countriesRep;
    protected $districtsRep;


    public function __construct(
        ShopRepository $shopRep,
        CountriesInterface $countriesRep,
        DistrictsInterface $districtsRep,
        UserContract $userRepo
    )
    {
        parent::__construct($userRepo);
        $this->shopRep = $shopRep;
        $this->countriesRep = $countriesRep;
        $this->districtsRep = $districtsRep;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }


        return view('admin.shops.index')->with([
            'title' => 'All shops',
            'articles' => $this->shopRep->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }


        return view('admin.shops.create')->with([
            'countries' => $this->countriesRep->getAllNoPagination(),
            'districts' => $this->districtsRep->getAllNoPagination(),
            'title' => 'Create shop',

        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }

        $data = $request->data($request);


        $createData = $request->data($request);
        $articleResult = $this->shopRep->addItem($createData);
        $this->shopRep->addItemTranslate($request, $articleResult);


        return redirect()->route('admin.shops.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }

        $article = $this->shopRep->getByID($id);

        return view('admin.shops.show')->with([
            'article' => $this->shopRep->getByID($id),
            'countries' => $this->countriesRep->getAllNoPagination(),
            'districts' => $this->districtsRep->getAllNoPagination(),
            'title' => 'Show shop',
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
        if (Gate::denies('SHOPS')) {
            abort(403);
        }

        $article = $this->shopRep->getByID($id);

        return view('admin.shops.edit')->with([
            'article' => $this->shopRep->getByID($id),
            'countries' => $this->countriesRep->getAllNoPagination(),
            'districts' => $this->districtsRep->getAllNoPagination(),
            'title' => 'Edit shop',
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, $id)
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }

        $editData = $request->data($request);
        $this->shopRep->updateItem($editData, $id);
        $this->shopRep->updateItemTranslate($request, $id);

        return redirect()->route('admin.shops.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('SHOPS')) {
            abort(403);
        }
        //   $this->shopRep->deleteItem($id);
        $this->shopRep->deleteItem($id);
        return redirect()->route('admin.shops.index')->with(['success' => 'Deleted']);
    }

}
