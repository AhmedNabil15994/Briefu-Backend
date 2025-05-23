<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Report\Transformers\Dashboard\ReportSubscriptionResource;
use Modules\Report\Transformers\Dashboard\ReportSubscriptionExportResource;
use Modules\Report\Repositories\Dashboard\ReportSubscriptionRepository as Subscription;

class ReportSubscriptionController extends Controller
{
    use DatatableExportTrait;

    function __construct(Subscription $subscription)
    {
        request()->merge(['title' => str_replace(" ", "-",__('apps::dashboard._layout.aside.subscriptions_reports'))]);
        $this->subscription = $subscription;
        $this->setRepository(Subscription::class);
        $this->setResource(new ReportSubscriptionResource([]));
        $this->setExportResource(new ReportSubscriptionExportResource([]));
    }

    public function index()
    {
        return view('report::dashboard.subscriptions.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->subscription->QueryTable($request));

        $datatable['data'] = ReportSubscriptionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    private function getData(Request $request, $type = "data_table")
    {
        $request->merge(['title' => __('apps::dashboard._layout.aside.subscriptions_reports')]);
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

    public function show($id)
    {
        $subscription = $this->subscription->findById($request);

        return view('report::dashboard.subscriptions.show',compact('subscription'));
    }

    public function query(Request $request)
    {
        return $this->subscription->QueryTable($request);
    }

    public function buildTotals($query)
    {
        $total_price = $query;
        $count = $query;
        $total_price = $total_price->sum('price');

        return [
            'id' => __('report::dashboard.reports.datatable.total') . ": ".$count->count(),
            'company' => '----',
            'package' => '----',
            'price' => number_format($total_price,1),
            'date_from' => '----',
            'date_to' => '----',
            'deleted_at' => '----',
            'created_at' => '----',
        ];
    }
}
