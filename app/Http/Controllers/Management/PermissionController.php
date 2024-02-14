<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Repositories\Management\PermissionRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    public $permissionRepository;

    /**
     * @param  PermissionRepository  $repository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
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
        return view('management.permission.index', compact('guards'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->validate([
           'name' => 'required',
           'guard_name' => 'required'
        ]);
        $this->permissionRepository->create($input);

        return response()->json(['message' => __('permissions.store_message')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $input = $request->validate([
            'name' => 'required',
            'guard_name' => 'required'
        ]);

        $this->permissionRepository
            ->update($permission,$input);

        return response()->json(['message' => __('permissions.update_message')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        if($permission){
            $permission->delete();
        }

        return response()->json(['message' => __('permissions.delete_message')]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getForDatatable(Request $request)
    {
        $permissions = $this->permissionRepository->query()->get();
        return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('action', function ($permission){
                return '<div class="dropdown">
                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end ">
                                <button class="dropdown-item editPermission" data-toggle="modal">
                                    <i data-feather="edit-2" class="me-50"></i>
                                    <span>'.__('permissions.datatable.columns.edit_btn').'</span>
                                </button>
                                <button class="dropdown-item deletePermission">
                                    <i data-feather="trash" class="me-50"></i>
                                    <span>'.__('permissions.datatable.columns.delete_btn').'</span>
                                </button>
                            </div>
                        </div>';
            })
            ->make(true);
    }
}
