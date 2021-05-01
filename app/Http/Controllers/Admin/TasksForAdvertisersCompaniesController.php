<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TasksAdvertsCompaniesRepository;
use App\Repositories\AdvertiserCompanyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\AdvertiserCompanyContract;
use App\Contracts\UserContract;

class TasksForAdvertisersCompaniesController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $task_advert_comp_rep;
    protected $advert_comp_rep;

    public function __construct(TasksAdvertsCompaniesRepository $task_advert_comp_rep, AdvertiserCompanyContract $advert_comp_rep, UserContract $userRepo)
    {

        parent::__construct($userRepo);
        $this->task_advert_comp_rep = $task_advert_comp_rep;
        $this->advert_comp_rep = $advert_comp_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('TASKS_FOR_ADVERTISERS_COMPANIES')) {
            abort(403);
        }

        return view('admin.tasksAdvertsCompanies.index')->with([
            'title' => 'All Advertiser companies',
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


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('TASKS_FOR_ADVERTISERS_COMPANIES')) {
            abort(403);
        }


        $article_result = $this->task_advert_comp_rep->addItem($request);

        return redirect()->route('admin.tasksForAdvertisers.index')->with(['success' => 'Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
