<?php

namespace Modules\Report\Repositories\Dashboard;

use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\Report\Entities\ReportSubscription;
use Hash;
use DB;

class ReportSubscriptionRepository
{
    use DatatableExportTrait;

    function __construct()
    {
        $this->subscription   = new ReportSubscription;

        $this->setQueryActionsCols([
            '#' => 'id',
            __('report::dashboard.reports.datatable.start_date') => 'date_from',
            __('report::dashboard.reports.datatable.end_date') => 'date_to',
            __('report::dashboard.reports.datatable.company') => 'company',
            __('report::dashboard.reports.datatable.package') => 'package',
            __('report::dashboard.reports.datatable.price') => 'price',
            __('report::dashboard.reports.datatable.created_at') => 'created_at',
        ]);
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $subscriptions = $this->subscription->orderBy($order, $sort)->get();
        return $subscriptions;
    }

    public function findById($id)
    {
        $subscription = $this->subscription->withDeleted()->find($id);
        return $subscription;
    }

    public function QueryTable($request)
    {
        $query = $this->subscription->where(function($query) use($request){
                    $query->where('id', 'like' , '%'. $request->input('search.value') .'%');

                    $query->orWhereHas('package', function ($query) use ($request) {
                        $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('title', 'like', '%'.$request->input('search.value').'%');
                        });
                    });

                    $query->orWhereHas('company', function ($query) use ($request) {
                        $query->whereHas('translations', function ($query) use ($request) {
                            $query->where('title', 'like', '%'.$request->input('search.value').'%');
                        });
                    });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Reports by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'])
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'])
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['package_id']) && $request['req']['package_id'])
            $query->where('package_id'  , $request['req']['package_id']);

        if (isset($request['req']['company_id']) && $request['req']['company_id'])
            $query->where('company_id'  , $request['req']['company_id']);

        return $query;
    }

}
