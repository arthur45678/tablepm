<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DistrictsRepository;
use App\Http\Requests\AdvertiserCompanyRequest;
use App\Models\AdvertiserCompany;
use App\Models\Country;
use App\Models\Trans\AdvertiserCompanyTrans;
use App\Repositories\AdvertiserCompanyRepository;
use App\Repositories\CountriesRepository;
use App\Repositories\IndustriesAdvertsCompaniesRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Contracts\AdvertiserCompanyContract;




class AdvertiserCompaniesController extends AdminController
{

    protected $advert_comp_rep;
    protected $countries_rep;
    protected $industries_advert_comp_rep;
    protected $users_rep;
    protected $districts_rep;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(AdvertiserCompanyContract $advert_comp_rep, CountriesRepository $countries_rep,
                                IndustriesAdvertsCompaniesRepository $industries_advert_comp_rep, UserRepository $users_rep,
                                DistrictsRepository $districts_rep)
    {

        parent::__construct($users_rep);

        $this->advert_comp_rep = $advert_comp_rep;
        $this->countries_rep = $countries_rep;
        $this->industries_advert_comp_rep = $industries_advert_comp_rep;
        $this->users_rep = $users_rep;
        $this->districts_rep = $districts_rep;

    }

    public function index()
    {
        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }

        return view('admin.advertisercompanies.index')
            ->with([
                'title' => 'All advertiser companies',
                'articles' => $this->advert_comp_rep->getAllAdvertCompanies(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }

        return view('admin.advertisercompanies.create')->with([
            'title' => 'Create Advertiser company',
            'districts' => $this->districts_rep->getAllNoPagination(),
            'countries' => $this->countries_rep->getAll(),
            'industries' => $this->industries_advert_comp_rep->getAllNoPagination(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertiserCompanyRequest $request)
    {
        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $data = $request->all();
        $data['role_id'] = 4;
        $user = $this->users_rep->addUser($data);
        $article_result = $this->advert_comp_rep->addAdvertCompany($request, $user);
        $this->advert_comp_rep->addAdvertCompanyTranslate($request, $article_result);
        $this->advert_comp_rep->addAdvertCompanyIndustries($request, $article_result);
        return redirect()->route('admin.advertiserCompanies.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }

        return view('admin.advertisercompanies.show')
            ->with([
                'title' => 'Advertiser company',
                'districts' => $this->districts_rep->getAllNoPagination(),
                'countries' => $this->countries_rep->getAll(),
                'article' => $this->advert_comp_rep->getCompanyById($id),
                'industries' => $this->industries_advert_comp_rep->getAllNoPagination()

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
        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }

        $article = $this->advert_comp_rep->getCompanyById($id);
        return view('admin.advertisercompanies.edit')->with([
            'title' => 'Edit advertiser company',
            'countries' => $this->countries_rep->getAll(),
            'districts' => $this->districts_rep->getAllNoPagination(),
            'article' => $article,
            'user' => $this->users_rep->getUserById($article->user_id),
            'industries' => $this->industries_advert_comp_rep->getAllNoPagination(),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertiserCompanyRequest $request, $id)
    {

        if (Gate::denies('ADVERTISER_COMPANIES')) {
            abort(403);
        }


      //  $article_result = $this->advert_comp_rep->addAdvertCompany($request, $user);

        $advertCompany = $this->advert_comp_rep->updateAdvertCompany($request, $id);

        $this->advert_comp_rep->updateAdvertCompanyTranslate($request, $id);
        $this->advert_comp_rep->updateIndustries($request, $id);

        $this->users_rep->updateAdvertUser($request, $id);


        return redirect()->route('admin.advertiserCompanies.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->advert_comp_rep->deleteAdvertisersCompany($id);
        return redirect()->route('admin.advertiserCompanies.index')->with(['success' => 'Deleted']);
    }

    public function search(Request $request)
    {
        $result = $this->advert_comp_rep->searchAdvertCompany($request);
        return response($result);
    }

    public function getSearched($id)
    {
        return view('admin.advertisercompanies.getSearched')
            ->with([
                'title' => 'Get searched',
                'article' => $this->advert_comp_rep->getCompanyById($id),
            ]);
    }
}
