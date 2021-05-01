<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IndustryRequest;
use App\Repositories\IndustriesAdvertsCompaniesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class IndustriesAdvertsCompaniesController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $industry_advert_comp_rep;

    public function __construct(IndustriesAdvertsCompaniesRepository $industry_advert_comp_rep, UserContract $userRepo)
    {

        parent::__construct($userRepo);
        $this->industry_advert_comp_rep = $industry_advert_comp_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        return view('admin.industriesAdvertsCompanies.index')
            ->with([
                'title' => 'All Industries for advertiser companies',
                'articles' => $this->industry_advert_comp_rep->getAll()
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        return view('admin.industriesAdvertsCompanies.create')
            ->with([
                'title' => 'Create Industry for advertiser company'
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
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $article_result = $this->industry_advert_comp_rep->addItem($request);

        $this->industry_advert_comp_rep->addItemTranslate($request, $article_result);
        return redirect()->route('admin.IndustriesAdvertsCompanies.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $article = $this->industry_advert_comp_rep->getByID($id);
        $this->vars = array_add($this->vars, 'article', $article);

        return view('admin.industriesAdvertsCompanies.show')
            ->with([
                'title' => 'Industry for advertiser company'
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
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }
        return view('admin.industriesAdvertsCompanies.edit')
            ->with([
                'title' => 'Edit industry for advertiser company',
                'article' => $this->industry_advert_comp_rep->getByID($id),
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
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $this->industry_advert_comp_rep->updateItem($request, $id);
        $this->industry_advert_comp_rep->updateItemTranslate($request, $id);

        return redirect()->route('admin.IndustriesAdvertsCompanies.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('INDUSTRIES_FOR_ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $this->industry_advert_comp_rep->deleteItem($id);
        return redirect()->route('admin.IndustriesAdvertsCompanies.index')->with(['success' => 'Deleted']);
    }
}
