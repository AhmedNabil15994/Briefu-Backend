<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\CompanyOwnerRequest;
use Modules\User\Transformers\Dashboard\CompanyOwnerResource;
use Modules\User\Repositories\Dashboard\CompanyOwnerRepository as CompanyOwner;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class CompanyOwnerController extends Controller
{

    function __construct(CompanyOwner $owner , Role $role)
    {
        $this->role  = $role;
        $this->owner = $owner;
    }

    public function index()
    {
        return view('user::dashboard.owners.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->owner->QueryTable($request));

        $datatable['data'] = CompanyOwnerResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        $roles = $this->role->getAllCompanyOwnersRoles('id','asc');
        return view('user::dashboard.owners.create',compact('roles'));
    }

    public function store(CompanyOwnerRequest $request)
    {
        try {
            $create = $this->owner->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('user::dashboard.owners.show');
    }

    public function edit($id)
    {
        $user = $this->owner->findById($id);
        $roles = $this->role->getAllCompanyOwnersRoles('id','asc');

        return view('user::dashboard.owners.edit',compact('user','roles'));
    }

    public function update(CompanyOwnerRequest $request, $id)
    {
        try {
            $update = $this->owner->update($request,$id);

            if ($update) {
              return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->owner->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->owner->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
