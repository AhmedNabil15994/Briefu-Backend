<?php

namespace Modules\Report\Repositories\Dashboard;

use Modules\Core\Traits\Dashboard\DatatableExportTrait;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;

class ReportUserRepository
{
    use DatatableExportTrait;

    function __construct()
    {
        $this->user  = User::with(['profileCv','nationality'])->where('id', '!=', auth()->id())->doesnthave('roles.perms');

        $this->setQueryActionsCols([
            '#' => 'id',
            __('report::dashboard.reports.datatable.client') => 'name',
            __('report::dashboard.reports.users.datatable.client_mobile') => 'mobile',
            __('report::dashboard.reports.users.datatable.client_email') => 'email',
            __('report::dashboard.reports.users.datatable.nationality_id') => 'nationality_id',
            __('report::dashboard.reports.users.datatable.gender') => 'gender',
            __('report::dashboard.reports.users.datatable.attributes') => 'attributes',
            __('report::dashboard.reports.users.datatable.subscription') => 'subscription',
            __('report::dashboard.reports.users.datatable.created_at') => 'created_at',
        ]);
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $users = $this->user->orderBy($order, $sort)->get();
        return $users;
    }

    public function findById($id)
    {
        $user = $this->user->find($id);
        return $user;
    }

    public function QueryTable($request)
    {
        $query = $this->user->where(function($query) use($request){
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('name', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
        });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if ((isset($request['req']['gender']) && $request['req']['gender']) || (isset($request['req']['country_id']) && $request['req']['country_id'])){

            $query->whereHas('profileCv', function($query) use($request){

                if (isset($request['req']['gender']) && $request['req']['gender'])
                    $query->where('gender',$request['req']['gender']);
    
                if (isset($request['req']['country_id']) && $request['req']['country_id'])
                    $query->where('country_id',$request['req']['country_id']);
            });
        }

        if (isset($request['req']['user_type']) && $request['req']['user_type'])
            $query->where('is_special', ($request['req']['user_type'] == 'special' ? 1 : 0));

        if (isset($request['req']['user_id']) && $request['req']['user_id'])
            $query->where('id', $request['req']['user_id']);

        if (isset($request['req']['attribute_id']) && $request['req']['attribute_id'])
            $query->whereHas('target', function($query) use($request){
                $query->where('attribute_id',$request['req']['attribute_id']);
            });
        
        return $query;
    }
}
