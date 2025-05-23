<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\Core\Traits\DataTable;
use Modules\Report\Transformers\Dashboard\ReportConsultationResource;
use Modules\Report\Transformers\Dashboard\ReportConsultationExportResource;
use Modules\Report\Repositories\Dashboard\ReportConsultationRepository as Consultation;

class ReportConsultationController extends Controller
{
    use DatatableExportTrait;

    function __construct(Consultation $consultation)
    {
        request()->merge(['title' => str_replace(" ", "-",__('apps::dashboard._layout.aside.consultations_report'))]);
        $this->exportFileName = __('apps::dashboard._layout.aside.consultations_report');
        $this->consultation = $consultation;
        $this->setRepository(Consultation::class);
        $this->setResource(new ReportConsultationResource([]));
        $this->setExportResource(new ReportConsultationExportResource([]));
    }

    public function index()
    {
        return view('report::dashboard.consultation.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->consultation->QueryTable($request));

        $datatable['data'] = ReportConsultationResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function switcher($id, $action)
    {
        try {
            $switch = $this->consultation->switcher($id, $action);

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
        $request->merge(['title' => __('apps::dashboard._layout.aside.consultations_report')]);
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
        return $this->consultation->QueryTable($request);
    }

    public function buildTotals($query)
    {
        $count = $query;

        return [
            'id' => __('report::dashboard.reports.datatable.total') . ": ".$count->count(),
            'subscription_id' => '',
            'client_id' => '',
            'link_client_id' => '',
            'client_mobile' => '',
            'client_email' => '',
            'country' => '',
            'ask_contact' => '',
            'admin_contact' => '',
            'consultation' => '',
            'deleted_at' => '',
            'created_at' => '',
        ];
    }
}
