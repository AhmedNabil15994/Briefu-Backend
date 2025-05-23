<?php

namespace Modules\Job\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Job\Transformers\Api\JobResource;
use Modules\Company\Transformers\Api\CompanySpecialJobsResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Job\Repositories\Api\JobRepository as Job;
use Modules\Course\Repositories\Api\CourseRepository as Course;
use Modules\Course\Transformers\Api\CourseResource;

class JobController extends ApiController
{

    public $job;

    function __construct(Job $job, Course $course)
    {
        $this->job = $job;
        $this->course = $course;
    }

    public function jobs(Request $request)
    {
        $jobs = $this->job->getAll($request);
        return JobResource::collection($jobs);
    }

    public function specialJobs(Request $request)
    {

        $companies = $this->job->getOneJobForCompany($request);

        return CompanySpecialJobsResource::collection($companies);
    }

    public function getJobById(Request $request, $id)
    {
        $job = $this->job->findById($request, $id);
        
        if(!$job)
            $this->error('job not found');

        return $this->response(new JobResource($job));
    }

    public function jobById(Request $request, $id)
    {
        $job = $this->job->findById($request, $id);

        if (!$job) {
            return $this->error(__('job::api.messages.job_not_found'));
        }

        $categoriesIds = $job->categories->pluck('id');

        $courses = $this->course->coursesByCategories($categoriesIds);

        return CourseResource::collection($courses);
    }

    public function jobsByCompanyId(Request $request, $id)
    {
        $jobs = $this->job->getJobsByCompanyId($request, $id);
        return JobResource::collection($jobs);
    }

    public function submitCv(Request $request)
    {
        $job = $this->job->findById($request, $request->job_id);
        if($job){

            if($job->subscription_access == 1){

                $checkUserAccess = checkUserAccessSubscription($request->user(), 'has_job_access_pro_subscription');
                if ($checkUserAccess)
                    return $this->error($checkUserAccess, [], 401);
            }
            $jobs = $this->job->submitCv($request,$job);
            if ($jobs) {
                return $this->response([], __('job::api.messages.Successfully_submiting_your_CV_for_this_job_OPP'));
            }
        }
        return $this->error(__('job::api.messages.Your CV already submited'),[],400);
    }

    public function favorites(Request $request)
    {
        $jobs = $this->job->addToFavorites($request);
        return $this->response($jobs, __('job::api.messages.Added to favorites'));
    }

    public function favoritesList()
    {

        $jobs = $this->job->favoritesList();
        return JobResource::collection($jobs);
    }

    public function deleteFavorites(Request $request)
    {
        $jobs = $this->job->deleteFavoriteJob($request);
        return $this->response([], __('job::api.messages.DELETED SUCCESSFULLY'));
    }

    public function mySubmitingCv()
    {
        $jobs = $this->job->userSubmiting();
        return JobResource::collection($jobs);
    }
}
