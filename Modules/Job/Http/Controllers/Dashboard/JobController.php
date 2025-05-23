<?php

namespace Modules\Job\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Job\Http\Requests\Dashboard\JobRequest;
use Modules\Job\Transformers\Dashboard\JobResource;
use Modules\Job\Repositories\Dashboard\JobRepository as Job;
use Modules\Job\Repositories\Dashboard\CVSRepository as Cvs;
use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;

class JobController extends Controller
{

    function __construct(Job $job , Company $company,Cvs $cvs)
    {
        $this->job     = $job;
        $this->company = $company;
        $this->cvs     = $cvs;
    }

    public function index()
    {
        return view('job::dashboard.jobs.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->job->QueryTable($request));

        $datatable['data'] = JobResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('job::dashboard.jobs.create');
    }

    public function store(JobRequest $request)
    {

        try {

            $company          = $this->company->findById($request['company']);
            $subscription     = $company->activeSubscription();

            if(!$subscription){

                return Response()->json([false  , __('job::dashboard.jobs.validation.company_id.company_not_have_subscription')]);
            }

            $countOldJobs     = $company->jobs()
                                        ->whereBetween('created_at',
                                        [
                                            $subscription['date_from'] , $subscription['date_to']
                                        ])->count();

            if ($subscription['job_posts'] > $countOldJobs) {
                $create = $this->job->create($request);
            }else{
                return Response()->json([false , 'This company can not add jobs more than subscription limit']);
            }

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id,Request $request)
    {
        $job = $this->job->findByIdAndFilter($id,$request);
        $cvs = $this->cvs->findByJobIdAllCvs($id,$request);

        return view('job::dashboard.jobs.show',compact('job','cvs'));
    }

    public function edit($id)
    {
        $job = $this->job->findById($id);

        return view('job::dashboard.jobs.edit',compact('job'));
    }

    public function update(JobRequest $request, $id)
    {
        try {
            $update = $this->job->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->job->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->job->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
