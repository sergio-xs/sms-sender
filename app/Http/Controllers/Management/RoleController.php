<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Repositories\Management\PermissionRepository;
use App\Repositories\Management\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public $roleRepository;
    public $permissionRepository;

    /**
     * @param  RoleRepository  $roleRepository
     * @param  PermissionRepository  $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
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
        $guards = array_keys(config('auth.guards'));
        $permissions = $this->permissionRepository->getAll();
        return view('management.role.index', compact('permissions', 'guards'));
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
        $input = $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $permissions = [];
        if (isset( $input['permissions'])) {
            $permissions = $input['permissions'];
            unset($input['permissions']);
        }
        $role = $this->roleRepository
            ->create($input);
        $role->givePermissionTo($permissions);
        return response()->json(['message' => __('roles.store_message')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $permissions = [];
        if (isset( $input['permissions'])) {
            $permissions = $input['permissions'];
            unset($input['permissions']);
        }

        $this->roleRepository
            ->update($role,$input);

        $role->syncPermissions($permissions);

        return response()->json(['message' => __('roles.update_message')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }


    /**
     * Get role datatable
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getForDatatable(Request $request)
    {
        $roles = $this->roleRepository->query()->with('permissions')->get();
        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role) {
                return '<div class="dropdown">
                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end ">
                                <button class="dropdown-item editRole" data-toggle="modal">
                                    <i data-feather="edit-2" class="me-50"></i>
                                    <span>'.__('roles.datatable.columns.edit_btn').'</span>
                                </button>
                            </div>
                        </div>';
            })
            ->make(true);
    }
}
