<?php

namespace Modules\Report\Repositories\Dashboard;

use Modules\Report\Entities\ReportSubscription;
use Hash;
use DB;
use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\Subscription\Entities\ClientSubscription;

class ReportClientSubscriptionRepository
{
    use DatatableExportTrait;

    function __construct()
    {
        $this->subscription   = new ClientSubscription;

        $this->setQueryActionsCols([
            '#' => 'id',
            __('report::dashboard.reports.datatable.expired_date') => 'expired_date',
            __('report::dashboard.reports.datatable.subscription') => 'subscription_id',
            __('report::dashboard.reports.datatable.client') => 'client_id',
            __('report::dashboard.reports.datatable.client_mobile') => 'client_mobile',
            __('report::dashboard.reports.datatable.client_email') => 'client_email',
            __('report::dashboard.reports.datatable.amount') => 'amount',
            __('report::dashboard.reports.datatable.paid_status') => 'paid',
            __('report::dashboard.reports.datatable.consultations_status') => 'consultations_status',
            __('report::dashboard.reports.datatable.action_type_status') => 'action_type',
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

        if (isset($request['req']['expired_date_from']) && $request['req']['expired_date_from'])
            $query->whereDate('expired_date'  , '>=' , $request['req']['expired_date_from']);

        if (isset($request['req']['expired_date_to']) && $request['req']['expired_date_to'])
            $query->whereDate('expired_date'  , '<=' , $request['req']['expired_date_to']);

        if (isset($request['req']['subscription_id']) && $request['req']['subscription_id'])
            $query->where('subscription_id'  , $request['req']['subscription_id']);

        if (isset($request['req']['is_free']) && $request['req']['is_free'])
            $query->where('is_free'  , $request['req']['is_free']);

        if (isset($request['req']['paid']) && $request['req']['paid']){
            if($request['req']['paid'] == 'paid'){

                $query->whereIn('paid'  , [
                    "paid",
                    "expired"
                ]);
            }else{
                
                $query->where('paid'  , $request['req']['paid']);
            }
        }

        if (isset($request['req']['action_type']) && $request['req']['action_type'])
            $query->where('action_type'  , $request['req']['action_type']);

        if (isset($request['req']['user_id']) && $request['req']['user_id'])
            $query->where('client_id'  , $request['req']['user_id']);

        return $query;
    }

}
