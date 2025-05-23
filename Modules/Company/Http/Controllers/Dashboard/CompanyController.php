<?php

namespace Modules\Company\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Traits\DataTable;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\Dashboard\CompanyRequest;
use Modules\Company\Transformers\Dashboard\CompanyResource;
use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;
use Modules\User\Entities\User;

class CompanyController extends Controller
{
    function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        return view('company::dashboard.companies.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->company->QueryTable($request));

        $datatable['data'] = CompanyResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('company::dashboard.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        try {
            $create = $this->company->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('company::dashboard.companies.show');
    }

    public function edit($id)
    {
        $users = User::whereHas('roles.perms', function ($query) {
            $query->where('name', 'company_dashboard_access');
        })->where(function ($query) use($id){

            $query->whereHas('companies',function ($query) use($id){
                $query->where('companies.id' , $id);
            });
            $query->orDoesntHave('companies');

        })->orderBy('id', 'DESC')->get();
        $company = $this->company->findById($id);
        // return $subscription = $company->activeSubscription();
        // return $company->jobs()->whereBetween('created_at',[$subscription['date_from'] , $subscription['date_to']])->count();

        return view('company::dashboard.companies.edit',compact('company','users'));
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $update = $this->company->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function updateSubscription(Request $request, $id)
    {
        try {
            $update = $this->company->updateSubscription($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->company->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->company->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
