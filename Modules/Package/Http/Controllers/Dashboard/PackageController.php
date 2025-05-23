<?php

namespace Modules\Package\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Traits\DataTable;
use Illuminate\Routing\Controller;
use Modules\Package\Http\Requests\Dashboard\PackageRequest;
use Modules\Package\Transformers\Dashboard\PackageResource;
use Modules\Package\Repositories\Dashboard\PackageRepository as Package;

class PackageController extends Controller
{
    function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function index()
    {
        return view('package::dashboard.packages.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->package->QueryTable($request));

        $datatable['data'] = PackageResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('package::dashboard.packages.create');
    }

    public function store(PackageRequest $request)
    {
        try {
            $create = $this->package->create($request);

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
        return view('package::dashboard.packages.show');
    }

    public function edit($id)
    {
        $package = $this->package->findById($id);

        return view('package::dashboard.packages.edit',compact('package'));
    }

    public function update(PackageRequest $request, $id)
    {
        try {
            $update = $this->package->update($request,$id);

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
            $delete = $this->package->delete($id);

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
            $deleteSelected = $this->package->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
