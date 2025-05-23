<?php

namespace Modules\Job\Repositories\Api;

use Modules\Job\Entities\Job;
use Modules\Company\Entities\Company;
use Modules\Job\Entities\JobFavorite;

class JobRepository
{
    public $job;
    public $favorite;
    public $company;
    public function __construct(Job $job, Company $company, JobFavorite $favorite)
    {
        $this->job             = $job;
        $this->favorite        = $favorite;
        $this->company         = $company;
    }

    public function getAll($request)
    {
        $jobs = $this->job->active()->with([
            'attributes', 'categories'
        ])->whereHas('company', function ($query) {
            $query->whereHas('subscriptions', function ($query) {
                $query
                ->where('is_paid', true)
                ->where('date_from', '<=', date('Y-m-d'))
                ->where(function ($query) {
                    $query->where('date_to', '>=', date('Y-m-d'));
                    $query->orWhere('date_to', '=', null);
                });
            });
        });

        if ($request['attribute_values']) {
            foreach ($request['attribute_values'] as $key => $value) {
                $jobs->whereHas('attributes', function ($query) use ($value) {
                    $query->where('attribute_value_id', $value);
                });
            }
        }

        if ($request['state_id']) {
            $jobs->whereHas('company', function ($query) use ($request) {
                $query->where('state_id', $request['state_id']);
            });
        }

        if ($request['governorate_id']) {
            $jobs->whereHas('cities', function ($query) use ($request) {
                $query->whereIn('city_id', (array)$request['governorate_id']);
            });
        }

        if ($request['search_title']) {
            $jobs->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%'. $request['search_title'] .'%');
                $query->orWhere('description', 'like', '%'. $request['search_title'] .'%');
            });
        }

        return $jobs->orderBy('id', 'DESC')->paginate(24);
    }

    public function getOneJobForCompany($request)
    {
        $jobs = $this->company->active()->whereHas('jobs', function ($query) {
            $query->active();
        })->with('specialJobs')
               ->whereHas('subscriptions', function ($query) {
                   $query->where('is_paid', true)
                    ->where('company_in_home', true)
                    ->where('date_from', '<=', date('Y-m-d'))
                    ->where(function ($query) {
                        $query->where('date_to', '>=', date('Y-m-d'));
                        $query->orWhere('date_to', '=', null);
                    });
               });

        return $jobs->latest()->limit(24)->get();
    }

    public function findById($request, $id)
    {
        return $job = $this->job->active()->find($id);
    }

    public function getJobsByCompanyId($request, $id)
    {
        $jobs = $this->job->active()->whereHas('company', function ($query) {
            $query->whereHas('subscriptions', function ($query) {
                $query
                ->where('is_paid', true)
                ->where('date_from', '<=', date('Y-m-d'))
                ->where(function ($query) {
                    $query->where('date_to', '>=', date('Y-m-d'));
                    $query->orWhere('date_to', '=', null);
                });
            });
        });

        if ($request['attribute_values']) {
            foreach ($request['attribute_values'] as $key => $value) {
                $jobs->whereHas('attributes', function ($query) use ($value) {
                    $query->where('attribute_value_id', $value);
                });
            }
        }

        if ($request['state_id']) {
            $jobs->whereHas('company', function ($query) use ($request) {
                $query->where('state_id', $request['state_id']);
            });
        }

        if ($request['governorate_id']) {
            $jobs->whereHas('cities', function ($query) use ($request) {
                $query->whereIn('city_id', (array)$request['governorate_id']);
            });
        }

        if ($request['search_title']) {
            $jobs->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%'. $request['search_title'] .'%');
                $query->orWhere('description', 'like', '%'. $request['search_title'] .'%');
            });
        }

        return $jobs->latest()->where('company_id', $id)->paginate(24);
    }

    public function submitCv($request, $job)
    {
        if($job->cvs()->count() && $job->cvs()->wherePivot('user_id' , auth()->id())->first()){

            return false;
        }

        $job->cvs()->attach(auth()->id());
        return true;

        return false;
    }

    public function addToFavorites($request)
    {
        $job = $this->job->where('id', $request['job_id'])->first();

        $toggle = $job->favorites()->toggle([auth()->id()]);

        return $toggle['attached'] ? 'attached' : 'detached';
    }

    public function favoritesList()
    {
        $jobs = $this->job->with('userCV')->whereHas('favorites', function ($query) {
            $query->where('user_id', auth()->id());
        })->latest()->get();

        return $jobs;
    }

    public function userSubmiting()
    {
        $jobs = auth()->user()->jobs()->with('userCV')->orderByDesc('job_users.created_at')->get();

        return $jobs;
    }

    public function deleteFavoriteJob($request)
    {
        $jobs = $this->favorite->where('user_id', auth()->id())->where('job_id', $request['job_id'])->delete();

        return true;
    }
}
