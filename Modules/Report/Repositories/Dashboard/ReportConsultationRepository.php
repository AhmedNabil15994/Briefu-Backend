<?php

namespace Modules\Report\Repositories\Dashboard;

use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\User\Entities\Consultation;
use Illuminate\Support\Facades\DB;

class ReportConsultationRepository
{
    use DatatableExportTrait;

    function __construct()
    {
        $this->consultation   = new Consultation;

        $this->setQueryActionsCols([
            '#' => 'id',
            __('report::dashboard.reports.datatable.client') => 'client_id',
            __('report::dashboard.reports.datatable.client_mobile') => 'client_mobile',
            __('report::dashboard.reports.datatable.client_email') => 'client_email',
            __('report::dashboard.reports.consultations.datatable.ask_contact') => 'ask_contact',
            __('report::dashboard.reports.consultations.datatable.admin_contact') => 'admin_contact',
            __('report::dashboard.reports.consultations.datatable.consultation') => 'consultation',
            __('report::dashboard.reports.datatable.created_at') => 'created_at',
        ]);
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $consultations = $this->consultation->orderBy($order, $sort)->get();
        return $consultations;
    }

    public function findById($id)
    {
        $consultation = $this->consultation->find($id);
        return $consultation;
    }

    public function QueryTable($request)
    {
        $query = $this->consultation->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');;
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

        if (isset($request['req']['consultation_id']) && $request['req']['consultation_id'])
            $query->where('consultation_id'  , $request['req']['consultation_id']);

        if (isset($request['req']['is_free']) && $request['req']['is_free'])
            $query->where('is_free'  , $request['req']['is_free']);

        if (isset($request['req']['paid']) && $request['req']['paid'])
            $query->where('paid'  , $request['req']['paid']);

        if (isset($request['req']['user_id']) && $request['req']['user_id'])
        $query->where('user_id', $request['req']['user_id']);

        return $query;
    }

    public function switcher($id, $action)
    {
        try {
            $model = $this->findById($id);
            if ($model->$action == 1) {
                $model->$action = 0;

            } elseif ($model->$action == 0) {
                $model->$action = 1;
            } else {
                return false;
            }

            $model->save();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
