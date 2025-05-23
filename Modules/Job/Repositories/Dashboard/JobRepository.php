<?php

namespace Modules\Job\Repositories\Dashboard;

use Modules\Job\Entities\Job;
use DB;

class JobRepository
{

    function __construct(Job $job)
    {
        $this->job   = $job;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $jobs = $this->job->orderBy($order, $sort)->get();
        return $jobs;
    }

    public function findById($id)
    {
        $job = $this->job->withDeleted()->findOrFail($id);
        return $job;
    }

    public function findByIdAndFilter($id)
    {
        $job = $this->job->withDeleted()->find($id);
        return $job;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $job = $this->job->create([
              'status'       => $request->status ? 1 : 0,
              'company_id'   => $request->company,
              'subscription_access'   => $request->subscription_access ? 1 : 0,
          ]);

          $job->attributes()->sync($request['attribute_values']);
          $job->categories()->sync($request['categories']);
          $job->cities()->attach($request['cities']);

          $this->translateTable($job,$request);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $job = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($job) : null;

        try {

            $job->update([
              'status'   => $request->status ? 1 : 0,
              'subscription_access'   => $request->subscription_access ? 1 : 0,
              'company_id'   => $request->company,
            ]);

            $job->cities()->sync($request['cities']);
            $job->attributes()->sync($request['attribute_values']);
            $job->categories()->sync($request['categories']);

            $this->translateTable($job,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($job)
    {
        $job->restore();
    }

    public function translateTable($model,$request)
    {
        foreach ($request['title'] as $locale => $value) {
          $model->translateOrNew($locale)->title           = $value;
          $model->translateOrNew($locale)->description     = $request['description'][$locale];
          $model->translateOrNew($locale)->slug            = slugfy($value);
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $job = $this->findById($id);

            if ($job->trashed()):
              $job->forceDelete();
            else:
              $job->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {

        $query = $this->job->with(['translations'])->where(function($query) use($request){
                      $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('title'            , 'like' , '%'. $request->input('search.value') .'%');
                              $query->orWhere('slug'             , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                      $query->orWhereHas('company', function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('title'            , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                });

        $company = $this->checkUserCompany();

        if (!empty($company))
            $query->where('company_id',$company->id);

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search jobs by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();


        return $query;
    }

    public function checkUserCompany()
    {
        $company = auth()->user()->companies()->first();

        if (empty($company))
            $company = null;

        return $company;
    }

}
