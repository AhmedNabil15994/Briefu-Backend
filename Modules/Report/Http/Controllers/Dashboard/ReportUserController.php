<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\Core\Traits\DataTable;
use Modules\Report\Transformers\Dashboard\ReportUserResource;
use Modules\Report\Transformers\Dashboard\ReportUserExportResource;
use Modules\Report\Repositories\Dashboard\ReportUserRepository as User;

class ReportUserController extends Controller
{
    use DatatableExportTrait;

    function __construct(User $user)
    {
        request()->merge(['title' => str_replace(" ", "-",__('apps::dashboard._layout.aside.users_report'))]);
        $this->exportFileName = __('apps::dashboard._layout.aside.users_report');
        $this->user = $user;
        $this->setRepository(User::class);
        $this->setResource(new ReportUserResource([]));
        $this->setExportResource(new ReportUserExportResource([]));
    }

    public function index()
    {
        return view('report::dashboard.users.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));

        $datatable['data'] = ReportUserResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function switcher($id, $action)
    {
        try {
            $switch = $this->user->switcher($id, $action);

            if ($switch) {
                return Response()->json();
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')], 400);

        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    private function getData(Request $request, $type = "data_table")
    {
        $request->merge(['title' => __('apps::dashboard._layout.aside.users_report')]);
        $query = $this->query($request);

        $total = $this->buildTotals($query);

        if ($type == 'data_table') {
            $datatable = DataTable::drawTable($request, $query);
            $resource = $this->model_resource;
        } elseif ($type == 'export') {

            $datatable = DataTable::drawPrint($request, $query);
            $resource = $this->export_resource;
        }

        $datatable['data'] = $resource::collection($datatable['data'])->add($total);

        return Response()->json($datatable);
    }

    public function query(Request $request)
    {
        return $this->user->QueryTable($request);
    }

    public function buildTotals($query)
    {
        $count = $query;

        return [
            'id' => __('report::dashboard.reports.datatable.total') . ": ".$count->count(),
            'subscription' => '',
            'name' => '',
            'email' => '',
            'mobile' => '',
            'country' => '',
            'gender' => '',
            'nationality_id' => '',
            'attributes' => '',
            'deleted_at' => '',
            'created_at' => '',
        ];
    }
}
