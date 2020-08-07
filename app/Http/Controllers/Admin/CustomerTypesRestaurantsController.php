<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCustomerTypeCreateRequest;
use App\Http\Requests\AdminCustomerTypeEditRequest;
use App\Http\Requests\CustomerTypeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Contracts\CustomerTypeContract;
use Validator;
use App\Contracts\UserContract;

class CustomerTypesRestaurantsController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $customerTypeRepo;

    public function __construct(CustomerTypeContract $customerTypeRepo, UserContract $userRepo)
    {  
        $this->customerTypeRepo = $customerTypeRepo;

        parent::__construct($userRepo);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }
        $articles = $this->customerTypeRepo->getAllCustomerTypes();
        $data =[
            'title' => 'All customer types for restaurants',
            'articles' => $articles,
        ];
        return view('admin.customerTypesRestaurants.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }

        return view('admin.customerTypesRestaurants.create')
            ->with(['title' => 'Create customer type for restaurants']);

    }

    /**
     * Create new customer type
     *
     * @param  AdminCustomerTypeCreateRequest  $request
     * @return redirect
     */
    public function store(AdminCustomerTypeCreateRequest $request)
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }
        $createData = $request->data($request);
        $articleResult = $this->customerTypeRepo->crateCustomerType($createData);
        $this->customerTypeRepo->addItemTranslate($request, $articleResult);
        
        return redirect()->route('admin.customerTypesRestaurants.index')->with(['success' => 'Created']);



    }

    /**
     * Get edit customer type page
     *
     * @param  int  $id
     * @return view
     */
    public function edit($id)
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }

        return view('admin.customerTypesRestaurants.edit')->with([
            'title' => 'Edit customer type for restaurants',
            'article' => $this->customerTypeRepo->getCustomerTypeById($id),
        ]);
    }

    /**
     * Edit the customer type
     *
     * @param  Request  $request
     * @param  int  $id
     * @return redirect
     */
    public function update(AdminCustomerTypeEditRequest $request, $id)
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }
        $editData = $request->data($request);
        $this->customerTypeRepo->updateItem($editData, $id);
        $this->customerTypeRepo->updateItemTranslate($request, $id);

        return redirect()->route('admin.customerTypesRestaurants.index')->with(['success' => 'Updated']);
    }

    /**
     * Delete customer type
     *
     * @param  int  $id
     * @return redirect
     */
    public function destroy($id)
    {
        if (Gate::denies('CUSTOMER_TYPES_RESTAURANTS')) {
            return redirect()->back();
        }

        $this->customerTypeRepo->deleteItem($id);
        return redirect()->route('admin.customerTypesRestaurants.index')->with(['success' => 'Deleted']);
    }
}
