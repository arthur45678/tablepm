<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Contracts\UserContract;
use App\Contracts\RoleContract;


class UsersController extends AdminController
{
    /**
     * Object of UserContract class
     *
     * @var userRepo
     */
    private $userRepo;

    /**
     * Object of RoleContract class
     *
     * @var roleRepo
     */
    private $roleRepo;


    public function __construct(UserContract $userRepo, RoleContract $roleRepo)
    {

        $this->middleware('UsersPermissions');

        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;

        parent::__construct($userRepo);
    }

    /**
     * Returns list of all admins
     *
     * @return view
     */
    public function index()
    {
        $users = $this->userRepo->getUsers();
        $data = [
            'users' => $users
        ];
        return view('admin.users.index', $data);
    }

    /**
     * Get create user page
     *
     * @return view
     */
    public function create()
    {
        $roles = $this->roleRepo->getRoles();
        $data = [
            'roles' => $roles
        ];
        return view('admin.users.create', $data);
    }

    /**
     * Create user
     *
     * @param  UserRequest $request
     * @return redirect
     */
    public function store(UserRequest $request)
    {
        $createData = $request->data($request);
        $user = $this->userRepo->addUser($createData);
        $user->roles()->attach($createData['role_id']);
        return redirect()->route('admin.users.index')->with(['success' => 'Updated']);
    }

    /**
     * Return edit user page
     *
     * @param  int  $id
     * @return view
     */
    public function edit($id)
    {
        $user = $this->userRepo->getUserById($id);
        $roles = $this->roleRepo->getRoles();
        $data = [
            'title' => 'Edit admin user',
            'user' => $user,
            'roles' => $roles
        ];
        return view('admin.users.edit', $data);
    }

    /**
     * Edit user
     *
     * @param  UsersUpdateRequest  $request
     * @param  int  $id
     * @return redirect
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        $data = $request->data($request);
        $user = $this->userRepo->getUserById($id);
        $updated = $this->userRepo->updateUser($user, $data);
        if($data['role_id']) {
            $user->roles()->sync([$data['role_id']]);
        }
        return redirect()->route('admin.users.index')->with(['success' => 'Updated']);
    }

    /**
     * Delete user
     *
     * @param  int  $id
     * @return redirect
     */
    public function destroy($id)
    {
        $this->userRepo->deleteUser($id);
        return redirect()->route('admin.users.index')->with(['success' => 'Deleted']);
    }

    public function getNewAdvertisers()
    {
        $users = $this->userRepo->getNewAdvertisers();
        $data = [
            'users' => $users
        ];
        return view('admin.users.new-users', $data);
    }

    public function approveNewUsers(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $user = $this->userRepo->getUserById($key);
            $updateData = [
                'is_active' => 1,
                'seen' =>1
            ];
            $user = $this->userRepo->updateUser($user, $updateData);
        }
        return redirect()->route('admin.users.index');
    }
}
