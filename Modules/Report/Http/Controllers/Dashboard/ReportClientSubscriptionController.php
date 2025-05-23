<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\Core\Traits\DataTable;
use Modules\Report\Transformers\Dashboard\ReportClientSubscriptionResource;
use Modules\Report\Transformers\Dashboard\ReportClientSubscriptionExportResource;
use Modules\Report\Repositories\Dashboard\ReportClientSubscriptionRepository as Subscription;

class ReportClientSubscriptionController extends Controller
{
    use DatatableExportTrait;

    function __construct(Subscription $subscription)
    {
        request()->merge(['title' => str_replace(" ", "-",__('apps::dashboard._layout.aside.client_subscription_report'))]);
        $this->subscription = $subscription;
        $this->setRepository(Subscription::class);
        $this->setResource(new ReportClientSubscriptionResource([]));
        $this->setExportResource(new ReportClientSubscriptionExportResource([]));
    }

    public function index()
    {
        return view('report::dashboard.client-subscriptions.index');
    }

    public function datatable(Request $request)
    {
        $query = $this->query($request);
        $total = $this->buildTotals($query);
        $datatable = DataTable::drawTable($request, $query);

        $datatable['data'] = ReportClientSubscriptionResource::collection($datatable['data'])->add($total);

        return Response()->json($datatable);
    }


    private function getData(Request $request, $type = "data_table")
    {
        $request->merge(['title' => __('apps::dashboard._layout.aside.client_subscription_report')]);
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
        return $this->subscription->QueryTable($request);
    }

    public function buildTotals($query)
    {
        $total_price = $query;
        $count = $query;
        $total_price = $total_price->sum('amount');

        return [

            'id' => __('report::dashboard.reports.datatable.total') . ": ". $count->count(),
            'subscription_id' => '----',
            'client_id' => '----',
            'client_mobile' => '----',
            'client_email' => '----',
            'link_client_id' => '----',
            'link_subscription_id' => '----',
            'amount' => number_format($total_price,1),
            'is_free' => '----',
            'consultations_status' => '----',
            'paid' => '----',
            'action_type' => '----',
            'expired_date' => '----',
            'deleted_at' => '----',
            'created_at' => '----',
        ];
    }
}
