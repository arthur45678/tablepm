<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\RestAccountTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\RestAccountTypeContract;
use App\Http\Requests\RestAccountTypeCreateRequest;
use App\Http\Requests\RestAccountTypeEditRequest;
use Validator;
use App\Contracts\UserContract;

class RestAccountTypeController extends AdminController
{
    /**
     * Object of RestAccountTypeContract class
     *
     * @var restAccountTypeRepo
     */
    private $restAccountTypeRepo;

    public function __construct(RestAccountTypeContract $restAccountTypeRepo, UserContract $userRepo)
    {  
        $this->restAccountTypeRepo = $restAccountTypeRepo;

        parent::__construct($userRepo);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }

        return view('admin.restAccountType.index')->with([
            'title' => 'All account types for restaurants',
            'articles' => $this->restAccountTypeRepo->getAllRestAccountTypes()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }

        return view('admin.restAccountType.create')->with([
            'title' => 'Create account type for restaurants'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestAccountTypeCreateRequest $request)
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }
        
        $createData = $request->data($request);
        $articleResult = $this->restAccountTypeRepo->createRestAccountType($createData);
        $this->restAccountTypeRepo->addItemTranslate($request, $articleResult);

        return redirect()->route('admin.restAccountType.index')->with(['success' => 'Created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }

        return view('admin.restAccountType.edit')->with([
            'title' => 'Edit account type for restaurants',
            'article' => $this->restAccountTypeRepo->getRestAccountTypeById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestAccountTypeEditRequest $request, $id)
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }
        $editData = $request->data($request);
        $this->restAccountTypeRepo->updateItem($editData, $id);
        $this->restAccountTypeRepo->updateItemTranslate($request, $id);

        return redirect()->route('admin.restAccountType.index')->with(['success' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('RESTAURANT_ACCOUNT_TYPE')) {
            return redirect()->back();
        }

        $this->restAccountTypeRepo->deleteItem($id);
        return redirect()->route('admin.restAccountType.index')->with(['success' => 'Deleted']);
    }
}
