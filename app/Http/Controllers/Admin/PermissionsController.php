<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\PermissionsRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Contracts\UserContract;

class PermissionsController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    protected $per_rep;
    protected $rol_rep;

    public function __construct(PermissionsRepository $per_rep, RoleRepository $roses_rep, UserContract $userRepo)
    {
        parent::__construct($userRepo);

        $this->per_rep = $per_rep;
        $this->rol_rep = $roses_rep;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Gate::denies('EDIT_PERMISSIONS')) {
            abort(403);
        }




        return view('admin.permissions.index')->with([
         'title' => "Roles",
         'permissions' => $this->per_rep->getAll(),
         'roles' => $this->rol_rep->getRoles(),

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
    public function store(Request $request)
    {
        $this->per_rep->changePermissions($request);
        return redirect()->route('admin.permissions.index')->with(['success' => 'Updated']);
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
