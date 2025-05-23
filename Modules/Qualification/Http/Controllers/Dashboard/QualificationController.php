<?php

namespace Modules\Qualification\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Qualification\Http\Requests\Dashboard\QualificationRequest;
use Modules\Qualification\Transformers\Dashboard\QualificationResource;
use Modules\Qualification\Repositories\Dashboard\QualificationRepository as Qualification;

class QualificationController extends Controller
{

    function __construct(Qualification $qualification)
    {
        $this->qualification = $qualification;
    }

    public function index()
    {
        return view('qualification::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->qualification->QueryTable($request));

        $datatable['data'] = QualificationResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('qualification::dashboard.create');
    }

    public function store(QualificationRequest $request)
    {
        try {
            $create = $this->qualification->create($request);

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
        return view('qualification::dashboard.show');
    }

    public function edit($id)
    {
        $qualification = $this->qualification->findById($id);

        return view('qualification::dashboard.edit',compact('qualification'));
    }

    public function update(QualificationRequest $request, $id)
    {
        try {
            $update = $this->qualification->update($request,$id);

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
            $delete = $this->qualification->delete($id);

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
            $deleteSelected = $this->qualification->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
