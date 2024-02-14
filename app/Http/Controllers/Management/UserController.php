<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Management\RoleRepository;
use App\Repositories\Management\UserRepository;
use App\Repositories\Management\PermissionRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * @var UserRepository
     * @var RoleRepository
     * @var PermissionRepository
     */
    public $userRepository;
    public $permissionRepository;
    public $roleRepository;

    /**
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        UserRepository       $userRepository,
        RoleRepository       $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gsmBoxes = $this->setGsmBoxNameCorrect();
        $permissions = $this->permissionRepository->getAll();
        $roles = $this->roleRepository->query()->with('permissions')->get();
        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role->name] = $role->permissions->pluck('id');
        }
        return view('management.user.index', compact('roles', 'permissions', 'rolePermissions', 'gsmBoxes'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'guard' => 'required',
            'permissions' => 'nullable|exists:permissions,name'
        ]);
        $permissions = [];
        if (isset($input['permissions'])) {
            $permissions = $input['permissions'];
            unset($input['permissions']);
        }
        $user = $this->userRepository->create($input);

        $user->givePermissionTo($permissions, $input['guard']);

        return response()->json(['message' => __('users.store_message')]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'guard' => 'required',
            'permissions' => 'nullable|exists:permissions,name'
        ]);
        $permissions = [];
        if (isset($input['permissions'])) {
            $permissions = $input['permissions'];
            unset($input['permissions']);
        }
        $this->userRepository->update($user, $input);

        $user->syncPermissions([]);
        $user->givePermissionTo($permissions, $input['guard']);

        return response()->json(['message' => __('users.update_message')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
        }

        return response()->json(['message' => __('users.delete_message')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getForDatatable(Request $request)
    {
        $users = $this->userRepository->query()->with('roles', 'roles.permissions', 'permissions');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return $user->action_buttons;
            })
            ->addColumn('role', function ($user) {
                return @$user->roles->first()->name;
            })
            ->addColumn('gsm_permissions', function ($user) {
                return $user->gsm_permissions != null ? json_decode($user->gsm_permissions, true) : [];
            })
            ->make(true);
    }

    /** Set gsm box permissions
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function setGsmBoxPermissions(Request $request, User $user)
    {
        $input['gsm_permissions'] = (array)($request->gsm_box);

        $this->userRepository->update($user, $input);

        return response()->json(['message' => __('users.gsm_message')]);
    }

    /** Fix gsm box provider name
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function setGsmBoxNameCorrect()
    {
        $gsmBoxes = config('sms.providers.gsm-boxes');
        foreach ($gsmBoxes as $key => $value) {
            $formattedKey = strtolower(str_replace(' ', '', $key));
            if ($formattedKey != $key) {
                $gsmBoxes[$formattedKey] = $gsmBoxes[$key];
                unset($gsmBoxes[$key]);
            }
        }

        return $gsmBoxes;
    }
}
