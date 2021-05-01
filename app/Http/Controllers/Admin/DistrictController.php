<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\District;
use App\Repositories\DistrictsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class DistrictController extends AdminController
{

    protected $district_rep;

    public function __construct(DistrictsRepository $district_rep, UserContract $userRepo)
    {

        parent::__construct($userRepo);
        $this->district_rep = $district_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        return view('admin.districts.index')->with([
            'title' => 'All advertiser companies',
            'articles' => $this->district_rep->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        return view('admin.districts.create')->with([
            'title' => 'Create district',
            'countries' => Country::all(),
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
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        $article_result = $this->district_rep->addItem($request);

        $this->district_rep->addItemTranslate($request, $article_result);
        return redirect()->route('admin.districts.index')->with(['success' => 'Created']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        return view('admin.districts.edit')->with([
            'title' => 'Edit district',
            'article' => $this->district_rep->getByID($id),
            'countries' => Country::all(),
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
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        $this->district_rep->updateItem($request, $id);
        $this->district_rep->updateItemTranslate($request, $id);

        return redirect()->route('admin.districts.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('ADD_DISTRICTS')) {
            abort(403);
        }

        $this->district_rep->deleteItem($id);
        return redirect()->route('admin.districts.index')->with(['success' => 'Deleted']);
    }
}
