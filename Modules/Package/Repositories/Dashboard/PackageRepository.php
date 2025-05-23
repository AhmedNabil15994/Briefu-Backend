<?php

namespace Modules\Package\Repositories\Dashboard;

use Modules\Package\Entities\Package;
use DB;

class PackageRepository
{
    function __construct(Package $package)
    {
        $this->package   = $package;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $packages = $this->package->orderBy($order, $sort)->get();
        return $packages;
    }

    public function findById($id)
    {
        $package = $this->package->withDeleted()->find($id);
        return $package;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $package = $this->package->create([
            'status' => $request->status ? 1 : 0,
          ]);

          if($request->is_free){
            $this->package->where('is_free',1)->update(['is_free' => 0 ]);
            $package->is_free = 1;
            $package->save();
          }

          $this->packageLevels($package,$request);
          $this->translateTable($package,$request);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function packageLevels($package,$request)
    {
        $package->levels()->delete();

        foreach ($request['price'] as $key => $value) {
            $package->levels()->create([
                'price'                => $request->is_free ? 0 : $value,
                'sort'                 => $request['sort'][$key],
                'company_in_home'      => $request['company_in_home'][$key],
                'video_cv'             => $request['video_cv'][$key],
                'job_posts'            => $request['job_posts'][$key],
                'months'               => $request['months'][$key],
                'package_id'           => $package['id'],
            ]);
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $package = $this->findById($id);
        $request->restore ? $this->restoreSoftDelte($package) : null;

        try {
            $package->update([
              'status'                    => $request->status ? 1 : 0,
            ]);

            if($request->is_free){
                $this->package->where('is_free',1)->update(['is_free' => 0 ]);
                $package->is_free = 1;
                $package->save();
            }

            $this->packageLevels($package,$request);
            $this->translateTable($package,$request);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model,$request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            $model->translateOrNew($locale)->description = $request['description'][$locale];
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
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
        $query = $this->package->with(['translations'])->where(function($query) use($request){
                      $query->where('id' , 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                          $query->whereHas('translations', function($query) use($request) {
                              $query->where('title'            , 'like' , '%'. $request->input('search.value') .'%');
                          });
                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Categories by Created Dates
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

}
