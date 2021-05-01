<?php

namespace App\Http\Controllers\Site;

use App\Contracts\ContactsInterface;
use App\Contracts\CountriesInterface;
use App\Http\Requests\ContactsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CountriesRepository;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ContactsController extends SiteController
{

    /*Object of ContactsInterface class
     *
     * $contactsRep
     */
    private $contactsRep;


    /*
     * Object of CountriesInterface class
     *
     * $countriesRep
     */
    private $countriesRep;
    public function __construct(
        ContactsInterface $contactsRep,
        CountriesInterface $countriesRep
    )
    {
        parent::__construct();
        $this->contactsRep = $contactsRep;
        $this->countriesRep = $countriesRep;


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        return view('site.contacts.contactPage')
            ->with([
                'countries' => $this->countriesRep->getAll(),
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactsRequest $request)
    {
        $data = $request->data($request);

        $this->contactsRep->sendMessage($data);

        return redirect()->route('contacts.index')->with([
            'success' => 'Your message has been successfully sent'
        ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
