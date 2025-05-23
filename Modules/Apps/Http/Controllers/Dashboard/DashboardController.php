<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Company\Entities\Company;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseUser;
use Modules\Job\Entities\Job;
use Modules\Job\Entities\JobUser;
use Modules\Package\Entities\Package;
use Modules\User\Entities\User;
use Modules\User\Traits\Dashboard\UserCompanyTrait;

class DashboardController extends Controller
{
    use UserCompanyTrait;

    public function index(Request $request)
    {
        $company = null;
        $data = [];

        $company = auth()->user()->companies()->first();

        if (!empty($company)){
            $data['activeSubscription']    = $this->getActiveSubscription();
            $data['subscriptionsHistory']   = $this->getSubscriptionsHistory();
            $data['upcomingSubscriptions']  = $this->getUpcomingSubscriptions();
        }

        if(auth()->user()->can(['show_statistics','dashboard_access'])){

            $users_count = $this->getCountUser($request);
            $companies_count = $this->getCompanies($request);
            $all_companies_count = $this->getAllCompanies($request);
            $packages = $this->getPackages($request);

            $jobs = $this->getJobs($request);
            $cvs = $this->getCvs($request);

            $courses = $this->getCourses($request);
            $courseUsers = $this->getUserCourses($request);

            return view('apps::dashboard.index',compact(
                'company',
                'data',
                'users_count',
                'companies_count',
                'jobs',
                'cvs',
                'courses',
                'courseUsers',
                'all_companies_count',
                'packages'
            ));
        }

        return view('apps::dashboard.index',compact('company','data'));
    }

    public function companyDashboard()
    {
        return UserOwnerCompany::getCompany();
    }


    private function getCountUser($request)
    {
        return $this->filter($request, (new User()))->doesnthave('roles.perms')->count();
    }

    private function getCompanies($request)
    {
        return $this->filter($request, (new User()))->whereHas('roles.perms', function($query){
            $query->where('name','company_dashboard_access');
        })->count();
    }

    private function getAllCompanies($request)
    {
        return $this->filter($request, (new Company()))->count();
    }

    private function getPackages($request)
    {
        return $this->filter($request, (new Package()))->count();
    }

    private function getCourses($request)
    {
        return $this->filter($request, (new Course()))->count();
    }

    private function getUserCourses($request)
    {
        return $this->filter($request, (new CourseUser()))->count();
    }

    private function getJobs($request)
    {
        return $this->filter($request, (new Job()))->count();
    }

    private function getCvs($request)
    {
        return $this->filter($request, (new JobUser()))->count();
    }

    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
}
