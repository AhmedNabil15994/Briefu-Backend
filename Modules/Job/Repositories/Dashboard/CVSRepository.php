<?php

namespace Modules\Job\Repositories\Dashboard;

use Modules\Attribute\Entities\Attribute;
use Modules\Job\Entities\JobUser;
use Modules\User\Entities\User;
use DB;

class CVSRepository
{

    function __construct(JobUser $job, User $user, Attribute $attribute)
    {
        $this->job = $job;
        $this->attribute = $attribute;
        $this->user = $user;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $job = $this->job->orderBy($order, $sort)->get();
        return $job;
    }

    public function findById($id)
    {
        $job = $this->job->find($id);
        return $job;
    }

    public function findByJobIdAllCvs($id, $request)
    {
        $job = $this->job->where('job_id', $id);

        if (isset($request['attribute_values'])) {
            foreach ($request['attribute_values'] as $key => $value) {
                $job->whereHas('user.target', function ($query) use ($value) {
                    $query->where('attribute_value_id', $value);
                });
            }

        }

        if ($request->cv_status) {
            $job->whereIn('job_users.status', (array)$request->cv_status);
        }

        return $job->get();
    }

    public function findCvByJobId($userId, $jobId)
    {
        $cv = $this->job->where('user_id', $userId)->where('job_id', $jobId)->first();

        return $cv;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $job = $this->findById($id);

        try {

            $job->update([
                'status' => $request->status,
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->job->with(['user', 'job'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%'.$request->input('search.value').'%');
        });

        $company = $this->checkUserCompany();

        if (!empty($company)) {
            $query->whereHas('job', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            });
        }


        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search job by Created Dates
        if (isset($request['req']['from'])) {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to'])) {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['jobs'])) {
            $query->where('job_id', $request['req']['jobs']);
        }

        if (isset($request['req']['companies'])) {

            $query->whereHas('job', function ($query) use ($request) {
                $query->where('company_id', $request['req']['companies']);
            });

        }

        foreach ($this->attribute->where('is_field', true)->get() as $key => $attribute) {

            if (isset($request['req']['attribute_values['.$attribute['id'].''])) {
                $query->whereHas('user.target', function ($query) use ($request, $attribute) {
                    $query->where('attribute_value_id', $request['req']['attribute_values['.$attribute['id'].'']);
                });
            }

        }

        // foreach ($request['req']['attribute_values'] as $key => $value) {
        //
        //     $query->whereHas('user.target', function($query) use ($value){
        //         $query->where('attribute_value_id',$value);
        //     });
        // }

        return $query;
    }

    public function checkUserCompany()
    {
        $company = auth()->user()->companies()->first();

        if (empty($company)) {
            $company = null;
        }

        return $company;
    }

}
